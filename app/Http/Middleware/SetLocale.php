<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\Setting;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check user preference (if authenticated)
        if (auth()->check() && auth()->user()->locale) {
            $locale = auth()->user()->locale;
        } 
        // 2. Check session preference (e.g. guest who changed language)
        elseif (Session::has('locale')) {
            $locale = Session::get('locale');
        } 
        // 3. Fallback to global default setting
        else {
            $locale = Setting::get('default_locale', config('app.locale', 'es'));
        }

        App::setLocale($locale);
        Session::put('locale', $locale); // Keep session in sync

        return $next($request);
    }
}
