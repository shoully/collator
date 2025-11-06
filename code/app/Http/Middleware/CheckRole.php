<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = auth()->user();
        
        if (!$user) {
            abort(403);
        }

        // Normalize role parameter to match database values (Mentor, Mentee, guest)
        $normalizedRole = ucfirst(strtolower($role));
        if ($normalizedRole === 'Guest') {
            $normalizedRole = 'guest';
        }

        // Check if user type matches required role
        if ($user->type !== $normalizedRole) {
            abort(403);
        }

        return $next($request);
    }
}
