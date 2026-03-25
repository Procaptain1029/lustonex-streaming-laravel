<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Response;

class NoCacheServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Configurar headers de no-cache para todas las respuestas
        Response::macro('withNoCache', function () {
            return $this->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Thu, 01 Jan 1970 00:00:00 GMT',
                'Last-Modified' => gmdate('D, d M Y H:i:s') . ' GMT',
                'ETag' => '',
            ]);
        });

        // Desactivar cache de vistas en desarrollo
        if (app()->environment('local', 'development')) {
            config(['view.cache' => false]);
            config(['cache.default' => 'array']);
        }
    }
}
