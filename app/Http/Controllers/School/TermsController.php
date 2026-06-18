<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    /**
     * Show the Terms & Conditions acceptance page.
     */
    public function show()
    {
        $school = auth()->user()->school;

        if (!$school || empty($school->terms_and_conditions)) {
            return redirect()->route('school.dashboard');
        }

        return view('school.terms.show', compact('school'));
    }

    /**
     * Handle the user's acceptance of Terms & Conditions.
     */
    public function accept(Request $request)
    {
        $request->validate([
            'accepted' => 'required|accepted',
        ]);

        $user = $request->user();
        $user->update(['terms_accepted_at' => now()]);

        return redirect()->route('school.dashboard')->with('success', 'Terms & Conditions accepted.');
    }
}
