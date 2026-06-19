<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;
        $query = SchoolClass::where('school_id', $schoolId)->with(['sections', 'subjects']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $classes = $query->latest()->paginate(15)->appends($request->query());

        return view('school.classes.index', compact('classes'));
    }

    public function create()
    {
        $this->authorizeManager();
        return view('school.classes.create');
    }

    public function store(Request $request)
    {
        $this->authorizeManager();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
            'sections' => 'nullable|array',
            'sections.*.name' => 'required|string|max:10',
            'sections.*.capacity' => 'required|integer|min:1',
        ]);

        $class = SchoolClass::create([
            'school_id' => auth()->user()->school_id,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
        ]);

        if (!empty($validated['sections'])) {
            foreach ($validated['sections'] as $sectionData) {
                $class->sections()->create($sectionData);
            }
        }

        return redirect()->route('school.classes.index')->with('success', 'Class created successfully.');
    }

    public function show(SchoolClass $class)
    {
        $this->authorizeAccess($class);
        $this->authorizeManager();
        $class->load(['sections.students', 'subjects', 'students']);

        return view('school.classes.show', compact('class'));
    }

    public function edit(SchoolClass $class)
    {
        $this->authorizeAccess($class);
        $this->authorizeManager();
        $class->load('sections');

        return view('school.classes.edit', compact('class'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $this->authorizeAccess($class);
        $this->authorizeManager();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
            'sections' => 'nullable|array',
            'sections.*.id' => 'nullable|exists:sections,id',
            'sections.*.name' => 'required|string|max:10',
            'sections.*.capacity' => 'required|integer|min:1',
        ]);

        $class->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
        ]);

        $existingSectionIds = [];
        if (!empty($validated['sections'])) {
            foreach ($validated['sections'] as $sectionData) {
                if (!empty($sectionData['id'])) {
                    $section = Section::where('id', $sectionData['id'])
                        ->where('class_id', $class->id)->first();
                    if ($section) {
                        $section->update(['name' => $sectionData['name'], 'capacity' => $sectionData['capacity']]);
                        $existingSectionIds[] = $section->id;
                    }
                } else {
                    $new = $class->sections()->create($sectionData);
                    $existingSectionIds[] = $new->id;
                }
            }
        }

        Section::where('class_id', $class->id)->whereNotIn('id', $existingSectionIds)->delete();

        return redirect()->route('school.classes.index')->with('success', 'Class updated successfully.');
    }

    public function destroy(SchoolClass $class)
    {
        $this->authorizeAccess($class);
        $this->authorizeManager();

        if ($class->students()->exists()) {
            return back()->with('error', 'Cannot delete class with assigned students.');
        }

        $class->delete();

        return redirect()->route('school.classes.index')->with('success', 'Class deleted successfully.');
    }

    private function authorizeAccess(SchoolClass $class): void
    {
        if ($class->school_id !== auth()->user()->school_id) {
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