<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolSettingController extends Controller
{
    public function index()
    {
        $this->authorizeManager();
        $school = auth()->user()->school;

        return view('school.settings.index', compact('school'));
    }

    public function update(Request $request)
    {
        $this->authorizeManager();
        $school = auth()->user()->school;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'short_name' => 'nullable|string|max:20',
            'motto' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($school->logo) {
                Storage::disk('public')->delete($school->logo);
            }
            $validated['logo'] = $request->file('logo')->store('school-logos', 'public');
        }

        $school->update($validated);

        return back()->with('success', 'School settings updated successfully.');
    }

    public function updateTerms(Request $request)
    {
        $this->authorizeManager();
        $school = auth()->user()->school;

        $validated = $request->validate([
            'terms_and_conditions' => 'nullable|string',
        ]);

        $school->update([
            'terms_and_conditions' => $validated['terms_and_conditions'],
            'terms_updated_at' => !empty($validated['terms_and_conditions']) ? now() : null,
        ]);

        // Auto-accept for the owner who updated the terms
        $request->user()->update(['terms_accepted_at' => now()]);

        return back()->with('success', 'Terms & Conditions updated successfully.');
    }

    private function authorizeManager(): void
    {
        if (!auth()->user()->canManageSchool()) {
            abort(403, 'You do not have permission to perform this action.');
        }
    }
}