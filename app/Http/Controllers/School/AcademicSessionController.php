<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\Term;
use Illuminate\Http\Request;

class AcademicSessionController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;
        $sessions = AcademicSession::where('school_id', $schoolId)
            ->with('terms')
            ->latest()
            ->paginate(10);

        return view('school.sessions.index', compact('sessions'));
    }

    public function create()
    {
        $this->authorizeManager();
        return view('school.sessions.create');
    }

    public function store(Request $request)
    {
        $this->authorizeManager();
        // Filter out empty term rows before validation
        if ($request->has('terms')) {
            $filteredTerms = collect($request->input('terms', []))
                ->filter(fn($term) => !empty($term['name']) || !empty($term['start_date']) || !empty($term['end_date']))
                ->values()
                ->toArray();
            $request->merge(['terms' => $filteredTerms]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean',
            'terms' => 'nullable|array',
            'terms.*.name' => 'required|string|max:255',
            'terms.*.start_date' => 'required|date',
            'terms.*.end_date' => 'required|date|after:terms.*.start_date',
        ]);

        if (!empty($validated['is_current'])) {
            AcademicSession::where('school_id', auth()->user()->school_id)
                ->update(['is_current' => false]);
        }

        $session = AcademicSession::create([
            'school_id' => auth()->user()->school_id,
            'name' => $validated['name'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_current' => $validated['is_current'] ?? false,
        ]);

        if (!empty($validated['terms'])) {
            foreach ($validated['terms'] as $termData) {
                $session->terms()->create($termData);
            }
        }

        return redirect()->route('school.sessions.index')->with('success', 'Academic session created successfully.');
    }

    public function edit(AcademicSession $session)
    {
        $this->authorizeAccess($session);
        $this->authorizeManager();
        $session->load('terms');

        return view('school.sessions.edit', compact('session'));
    }

    public function update(Request $request, AcademicSession $session)
    {
        $this->authorizeAccess($session);
        $this->authorizeManager();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean',
        ]);

        if (!empty($validated['is_current'])) {
            AcademicSession::where('school_id', auth()->user()->school_id)
                ->update(['is_current' => false]);
        }

        $session->update($validated);

        return redirect()->route('school.sessions.index')->with('success', 'Academic session updated successfully.');
    }

    public function destroy(AcademicSession $session)
    {
        $this->authorizeAccess($session);
        $this->authorizeManager();
        $session->delete();

        return redirect()->route('school.sessions.index')->with('success', 'Academic session deleted successfully.');
    }

    public function setCurrentTerm(Term $term)
    {
        $this->authorizeManager();
        $session = $term->academicSession;

        if ($session->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        // Unset current for all terms in this session
        Term::where('academic_session_id', $session->id)->update(['is_current' => false]);
        $term->update(['is_current' => true]);

        return back()->with('success', "Current term set to {$term->name}.");
    }

    private function authorizeAccess(AcademicSession $session): void
    {
        if ($session->school_id !== auth()->user()->school_id) {
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