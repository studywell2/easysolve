<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\School;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_name' => 'required',
            'school_email' => 'nullable|email',
            'school_phone' => 'nullable',

            'owner_first_name' => 'required',
            'owner_last_name' => 'required',
            'owner_email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        DB::transaction(function () use ($data, &$school, &$user) {
            // Assign the default (Starter) plan
            $plan = Plan::where('slug', 'starter')->first();

            $trialEndsAt = now()->addDays(14);

            $school = School::create([
                'name' => $data['school_name'],
                'email' => $data['school_email'] ?? null,
                'phone' => $data['school_phone'] ?? null,
                'subscription_status' => 'trial',
                'trial_ends_at' => $trialEndsAt,
                'plan_id' => $plan?->id,
            ]);

            $user = User::create([
                'school_id' => $school->id,
                'first_name' => $data['owner_first_name'],
                'last_name' => $data['owner_last_name'],
                'email' => $data['owner_email'],
                'password' => $data['password'],
                'role' => 'owner',
            ]);

            $school->update(['owner_id' => $user->id]);

            // Create the initial subscription record
            Subscription::create([
                'school_id' => $school->id,
                'plan_id' => $plan?->id,
                'status' => 'trial',
                'billing_cycle' => 'monthly',
                'starts_at' => now(),
                'trial_ends_at' => $trialEndsAt,
            ]);
        });

        // Auto-login after registration
        Auth::login($user);

        return redirect()->route('school.dashboard');
    }
}
