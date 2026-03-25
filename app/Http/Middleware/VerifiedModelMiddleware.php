<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedModelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // Verificar que el usuario esté autenticado y sea modelo
        if (!$user || !$user->isModel()) {
            abort(403, __('admin.flash.middleware.verified_denied'));
        }
        
        $profile = $user->profile;
        
        // Verificar que tenga perfil
        if (!$profile) {
            return redirect()->route('model.onboarding.index')
                           ->with('error', __('admin.flash.middleware.profile_incomplete'));
        }
        
        // Verificar que el perfil esté aprobado
        if ($profile->verification_status !== 'approved') {
            return redirect()->route('model.dashboard')
                           ->with('error', __('admin.flash.middleware.profile_pending'));
        }
        
        return $next($request);
    }
}
