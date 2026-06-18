<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTermsAccepted
{
    /**
     * Redirect school users who haven't accepted the latest Terms & Conditions.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Skip for guests or users without a school
        if (!$user || !$user->school_id) {
            return $next($request);
        }

        // Skip the terms routes themselves to avoid redirect loops
        if ($request->routeIs('school.terms.*')) {
            return $next($request);
        }

        if (!$user->hasAcceptedLatestTerms()) {
            return redirect()->route('school.terms.show');
        }

        return $next($request);
    }
}
