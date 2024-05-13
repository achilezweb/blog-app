<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            // Not authenticated
            return redirect('login');
        }

        // Flatten the roles array and split by comma to handle multiple roles in a single string
        $roles = collect($roles)->flatMap(function ($role) {
            return explode(',', $role);
        })->toArray();

        // Check if the user has any of the required roles
        if (!Auth::user()->hasAnyRole($roles)) {
            // User does not have any of the required roles
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
