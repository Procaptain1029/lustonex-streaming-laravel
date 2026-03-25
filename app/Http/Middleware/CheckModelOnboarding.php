<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModelOnboarding
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        if ($user && $user->isModel()) {
            $profile = $user->profile;
            
            if (!$profile || !$profile->isOnboardingComplete()) {
                // Prevenir loops de redirecciones si la ruta actual ya es onboarding
                if (!$request->routeIs('model.onboarding.*')) {
                    return redirect()->route('model.onboarding.index')
                        ->with('info', __('admin.flash.middleware.onboarding_required'));
                }
            }
        }
        
        return $next($request);
    }
}
