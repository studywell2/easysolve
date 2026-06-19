<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSubscriptionActive
{
    /**
     * Block school portal access when trial has expired
     * and no active subscription exists.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Skip for users without a school (super_admin, etc.)
        if (!$user || !$user->school_id) {
            return $next($request);
        }

        $school = $user->school;

        // Allow if on active trial
        if ($school->isOnTrial()) {
            return $next($request);
        }

        // Allow if has active subscription
        if ($school->hasActiveSubscription()) {
            return $next($request);
        }

        // Trial expired and no active subscription — allow billing routes only
        if ($request->routeIs('school.billing.*')) {
            return $next($request);
        }

        return redirect()->route('school.billing.index')
            ->with('error', 'Your trial has ended. Please choose a plan to continue.');
    }
}
