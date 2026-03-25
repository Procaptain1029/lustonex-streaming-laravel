<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and active
        if (auth()->check() && !auth()->user()->is_active) {
            // Allow access to logout and suspended routes
            if (!$request->routeIs('logout') && !$request->routeIs('account.suspended')) {
                return redirect()->route('account.suspended');
            }
        }

        return $next($request);
    }
}
