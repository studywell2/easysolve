<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\SchoolClass;
use App\Models\Term;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $query = Fee::where('school_id', $schoolId)->with(['schoolClass', 'term']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $fees = $query->latest()->paginate(15)->appends($request->query());

        return view('school.fees.index', compact('fees'));
    }

    public function create()
    {
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->active()->get();
        $terms = Term::whereHas('academicSession', fn($q) => $q->where('school_id', $schoolId))->get();

        return view('school.fees.create', compact('classes', 'terms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'class_id' => 'nullable|exists:classes,id',
            'term_id' => 'nullable|exists:terms,id',
            'description' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        Fee::create([...$validated, 'school_id' => auth()->user()->school_id]);

        return redirect()->route('school.fees.index')->with('success', 'Fee created successfully.');
    }

    public function edit(Fee $fee)
    {
        $this->authorizeAccess($fee);
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->active()->get();
        $terms = Term::whereHas('academicSession', fn($q) => $q->where('school_id', $schoolId))->get();

        return view('school.fees.edit', compact('fee', 'classes', 'terms'));
    }

    public function update(Request $request, Fee $fee)
    {
        $this->authorizeAccess($fee);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'class_id' => 'nullable|exists:classes,id',
            'term_id' => 'nullable|exists:terms,id',
            'description' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        $fee->update($validated);

        return redirect()->route('school.fees.index')->with('success', 'Fee updated successfully.');
    }

    public function destroy(Fee $fee)
    {
        $this->authorizeAccess($fee);
        $fee->delete();

        return redirect()->route('school.fees.index')->with('success', 'Fee deleted successfully.');
    }

    private function authorizeAccess(Fee $fee): void
    {
        if ($fee->school_id !== auth()->user()->school_id) {
            abort(403);
        }
    }
}