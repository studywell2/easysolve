<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Mail\AnnouncementNotificationMail;
use App\Models\Announcement;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $query = Announcement::where('school_id', $schoolId)->with(['creator', 'schoolClass']);

        // Non-managers only see announcements visible to them
        if (!auth()->user()->canManageSchool()) {
            $query->visibleTo(auth()->user());
        }

        if ($request->filled('audience')) {
            $query->where('audience', $request->audience);
        }

        $announcements = $query->latest()->paginate(12)->appends($request->query());

        return view('school.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $this->authorizeManager();
        $classes = SchoolClass::where('school_id', auth()->user()->school_id)->active()->get();

        return view('school.announcements.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:5000',
            'audience' => 'required|in:all,parents,students,class',
            'class_id' => ['nullable', Rule::exists('classes', 'id')->where('school_id', $schoolId)],
        ]);

        if ($validated['audience'] === 'class') {
            $request->validate(['class_id' => 'required']);
        } else {
            $validated['class_id'] = null;
        }

        Announcement::create([
            ...$validated,
            'school_id' => $schoolId,
            'created_by' => auth()->id(),
        ]);

        // Send email notifications to relevant users
        $recipients = $this->getAnnouncementRecipients($validated, $schoolId);
        foreach ($recipients as $recipient) {
            Mail::to($recipient->email)->queue(new AnnouncementNotificationMail($announcement));
        }

        return redirect()->route('school.announcements.index')->with('success', 'Announcement published successfully.');
    }

    public function show(Announcement $announcement)
    {
        $this->authorizeAccess($announcement);
        $announcement->load(['creator', 'schoolClass']);

        return view('school.announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        $this->authorizeAccess($announcement);
        $this->authorizeManager();
        $classes = SchoolClass::where('school_id', auth()->user()->school_id)->active()->get();

        return view('school.announcements.edit', compact('announcement', 'classes'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $this->authorizeAccess($announcement);
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:5000',
            'audience' => 'required|in:all,parents,students,class',
            'class_id' => ['nullable', Rule::exists('classes', 'id')->where('school_id', $schoolId)],
        ]);

        if ($validated['audience'] === 'class') {
            $request->validate(['class_id' => 'required']);
        } else {
            $validated['class_id'] = null;
        }

        $announcement->update($validated);

        return redirect()->route('school.announcements.index')->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $this->authorizeAccess($announcement);
        $this->authorizeManager();
        $announcement->delete();

        return redirect()->route('school.announcements.index')->with('success', 'Announcement deleted successfully.');
    }

    // ─── Email Notification Helpers ───────────────────

    private function getAnnouncementRecipients(array $validated, int $schoolId)
    {
        $query = User::where('school_id', $schoolId)->where('is_active', true);

        switch ($validated['audience']) {
            case 'parents':
                $query->where('role', 'parent');
                break;
            case 'students':
                $query->where('role', 'student');
                break;
            case 'class':
                $query->where('role', 'student')->where('class_id', $validated['class_id']);
                break;
            case 'all':
            default:
                $query->whereIn('role', ['student', 'parent', 'teacher']);
                break;
        }

        return $query->get();
    }

    private function authorizeAccess(Announcement $announcement): void
    {
        if ($announcement->school_id !== auth()->user()->school_id) {
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
