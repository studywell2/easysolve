<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\SchoolEvent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        $query = SchoolEvent::where('school_id', $schoolId)->with(['schoolClass', 'creator']);

        // Role-based filtering
        if (!$user->canManageSchool()) {
            $query->visibleTo($user);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('month')) {
            $query->whereMonth('start_date', $request->month);
        }

        // Upcoming vs all
        $view = $request->get('view', 'upcoming');
        if ($view === 'upcoming') {
            $query->where('start_date', '>=', today())->orderBy('start_date');
        } else {
            $query->latest('start_date');
        }

        $events = $query->paginate(15)->appends($request->query());

        // Stats for manager dashboard
        $upcomingCount = SchoolEvent::where('school_id', $schoolId)
            ->where('start_date', '>=', today())
            ->when(!$user->canManageSchool(), fn ($q) => $q->visibleTo($user))
            ->count();

        return view('school.events.index', compact('events', 'upcomingCount'));
    }

    public function create()
    {
        $this->authorizeManager();
        $classes = SchoolClass::where('school_id', auth()->user()->school_id)->active()->get();

        return view('school.events.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'type' => 'required|in:exam,holiday,ptc,sports,meeting,other',
            'audience' => 'required|in:all,parents,students,class',
            'class_id' => ['nullable', Rule::exists('classes', 'id')->where('school_id', $schoolId)],
        ]);

        if ($validated['audience'] !== 'class') {
            $validated['class_id'] = null;
        }

        SchoolEvent::create([
            ...$validated,
            'school_id' => $schoolId,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('school.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(SchoolEvent $event)
    {
        $this->authorizeAccess($event);
        $this->authorizeManager();
        $classes = SchoolClass::where('school_id', auth()->user()->school_id)->active()->get();

        return view('school.events.edit', compact('event', 'classes'));
    }

    public function update(Request $request, SchoolEvent $event)
    {
        $this->authorizeAccess($event);
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'type' => 'required|in:exam,holiday,ptc,sports,meeting,other',
            'audience' => 'required|in:all,parents,students,class',
            'class_id' => ['nullable', Rule::exists('classes', 'id')->where('school_id', $schoolId)],
        ]);

        if ($validated['audience'] !== 'class') {
            $validated['class_id'] = null;
        }

        $event->update($validated);

        return redirect()->route('school.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(SchoolEvent $event)
    {
        $this->authorizeAccess($event);
        $this->authorizeManager();
        $event->delete();

        return redirect()->route('school.events.index')->with('success', 'Event deleted successfully.');
    }

    // ─── Private Helpers ──────────────────────────────

    private function authorizeAccess(SchoolEvent $event): void
    {
        if ($event->school_id !== auth()->user()->school_id) {
            abort(403);
        }
    }

    private function authorizeManager(): void
    {
        if (!auth()->user()->canManageSchool()) {
            abort(403, 'You do not have permission to perform this action.');
        }
    }
}
