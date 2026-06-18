<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSchools = School::count();
        $totalUsers = User::count();
        $activeSchools = School::where('subscription_status', 'active')->count();
        $trialSchools = School::where('subscription_status', 'trial')->count();
        $recentSchools = School::with('owner')->withCount('users')->latest()->take(5)->get();
        $recentUsers = User::with('school')->latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'totalSchools', 'totalUsers', 'activeSchools', 'trialSchools', 'recentSchools', 'recentUsers'
        ));
    }
}
