<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        $query = School::with('owner')->withCount(['users', 'classes']);

        if ($request->filled('status')) {
            $query->where('subscription_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $schools = $query->latest()->paginate(15)->appends($request->query());

        return view('admin.schools.index', compact('schools'));
    }

    public function show(School $school)
    {
        $school->load(['owner', 'users' => fn ($q) => $q->latest()->take(10)]);
        $school->loadCount(['users', 'classes']);

        return view('admin.schools.show', compact('school'));
    }

    public function edit(School $school)
    {
        $plans = Plan::orderBy('sort_order')->get();

        return view('admin.schools.edit', compact('school', 'plans'));
    }

    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subscription_status' => 'required|in:trial,active,expired',
            'plan_id' => 'nullable|exists:plans,id',
        ]);

        $school->update($validated);

        return redirect()->route('admin.schools.index')->with('success', 'School updated successfully.');
    }

    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('admin.schools.index')->with('success', 'School deleted successfully.');
    }
}
