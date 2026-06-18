<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    /**
     * Root dashboard — redirects to the correct portal based on role.
     */
    public function index()
    {
        $user = auth()->user();

        // Platform super_admin → admin panel
        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Anyone with a school → school portal
        if ($user->school_id) {
            return redirect()->route('school.dashboard');
        }

        // Fallback — no school, no admin access
        auth()->logout();
        return redirect()->route('login')->with('error', 'Your account is not linked to any school.');
    }
}
