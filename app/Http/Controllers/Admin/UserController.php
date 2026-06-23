<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('school')->where('role', '!=', 'super_admin');

        if ($request->filled('school')) {
            $query->where('school_id', $request->school);
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15)->appends($request->query());
        $schools = School::orderBy('name')->pluck('name', 'id');

        return view('admin.users.index', compact('users', 'schools'));
    }

    public function show(User $user)
    {
        $user->load('school');

        return view('admin.users.show', compact('user'));
    }

    public function toggleActive(Request $request, User $user)
    {
        if ($user->role === 'super_admin') {
            return back()->with('error', 'Cannot modify super admin accounts.');
        }

        $user->update(['is_active' => ! $user->is_active]);

        $status = $user->fresh()->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "User {$user->full_name} has been {$status}.");
    }
}
