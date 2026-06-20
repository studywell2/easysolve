<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\School;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    public function create(Request $request)
    {
        $plans = Plan::active()->orderBy('sort_order')->get();
        $setup = $request->boolean('setup');

        return view('admin.schools.create', compact('plans', 'setup'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'plan_id' => 'required|exists:plans,id',
            'trial_days' => 'required|integer|min:1|max:365',

            'owner_first_name' => 'required|string|max:255',
            'owner_last_name' => 'required|string|max:255',
            'owner_email' => 'required|email|max:255|unique:users,email',
            'owner_password' => 'required|string|min:8',
        ]);

        DB::transaction(function () use ($validated, &$school, &$user) {
            $plan = Plan::findOrFail($validated['plan_id']);
            $trialEndsAt = now()->addDays($validated['trial_days']);

            $school = School::create([
                'name' => $validated['name'],
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'subscription_status' => 'trial',
                'trial_ends_at' => $trialEndsAt,
                'plan_id' => $plan->id,
            ]);

            $user = User::create([
                'school_id' => $school->id,
                'first_name' => $validated['owner_first_name'],
                'last_name' => $validated['owner_last_name'],
                'email' => $validated['owner_email'],
                'password' => $validated['owner_password'],
                'role' => 'owner',
            ]);

            $school->update(['owner_id' => $user->id]);

            Subscription::create([
                'school_id' => $school->id,
                'plan_id' => $plan->id,
                'status' => 'trial',
                'billing_cycle' => 'monthly',
                'starts_at' => now(),
                'trial_ends_at' => $trialEndsAt,
            ]);
        });

        return redirect()->route('admin.schools.show', $school)
            ->with('success', "School \"{$school->name}\" created successfully. The owner can log in with their email and password.");
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
