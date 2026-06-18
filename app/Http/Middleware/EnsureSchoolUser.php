<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSchoolUser
{
    /**
     * School portal — any user with a school_id.
     * Owners/admins/teachers get full management access.
     * Students/parents get limited view access.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->school_id) {
            abort(403, 'Access denied. You do not have access to a school portal.');
        }

        return $next($request);
    }
}