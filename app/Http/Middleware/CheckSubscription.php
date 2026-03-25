<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $modelId = $request->route('model') ?? $request->route('id');
        
        if (!$modelId) {
            return $next($request);
        }

        $user = auth()->user();

        // Si es admin, permitir acceso
        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        // Si es el propio modelo, permitir acceso
        if ($user && $user->id == $modelId) {
            return $next($request);
        }

        // Verificar suscripción activa
        if ($user && $user->hasActiveSubscriptionTo($modelId)) {
            return $next($request);
        }

        return redirect()->back()->with('error', __('admin.flash.middleware.subscription_required'));
    }
}
