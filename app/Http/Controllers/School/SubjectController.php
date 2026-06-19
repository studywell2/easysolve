<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;
        $query = Subject::where('school_id', $schoolId)->withCount('classes');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('code', 'like', "%{$request->search}%");
            });
        }

        $subjects = $query->latest()->paginate(15)->appends($request->query());

        return view('school.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $this->authorizeManager();
        return view('school.subjects.create');
    }

    public function store(Request $request)
    {
        $this->authorizeManager();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:20|unique:subjects,code,NULL,id,school_id,' . auth()->user()->school_id,
            'description' => 'nullable|string|max:500',
        ]);

        Subject::create([
            ...$validated,
            'school_id' => auth()->user()->school_id,
        ]);

        return redirect()->route('school.subjects.index')->with('success', 'Subject created successfully.');
    }

    public function edit(Subject $subject)
    {
        $this->authorizeAccess($subject);
        $this->authorizeManager();

        return view('school.subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $this->authorizeAccess($subject);
        $this->authorizeManager();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:20|unique:subjects,code,' . $subject->id . ',id,school_id,' . auth()->user()->school_id,
            'description' => 'nullable|string|max:500',
        ]);

        $subject->update($validated);

        return redirect()->route('school.subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $this->authorizeAccess($subject);
        $this->authorizeManager();
        $subject->delete();

        return redirect()->route('school.subjects.index')->with('success', 'Subject deleted successfully.');
    }

    private function authorizeAccess(Subject $subject): void
    {
        if ($subject->school_id !== auth()->user()->school_id) {
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