<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Workaround for missing mail hint path in corrupted/bugged Laravel installation
        // Trying to point to 'html' specifically to fix direct component resolution
        if (file_exists(base_path('vendor/laravel/framework/src/Illuminate/Mail/resources/views/html'))) {
            $this->loadViewsFrom(base_path('vendor/laravel/framework/src/Illuminate/Mail/resources/views/html'), 'mail');
        }

        // Compartir contador de perfiles/usuarios pendientes con todas las vistas de admin
        \Illuminate\Support\Facades\View::composer(['layouts.admin', 'admin.*'], function ($view) {
            try {
                // Usuarios pendientes
                $pendingCount = \App\Models\User::whereNotIn('role', ['admin', 'fan'])
                    ->where(function ($query) {
                        $query->whereNull('email_verified_at')
                            ->orWhereDoesntHave('profile')
                            ->orWhereHas('profile', function ($q) {
                                $q->where('verification_status', '!=', 'approved')
                                    ->orWhereNull('verification_status');
                            });
                    })
                    ->count();

                // Fotos pendientes
                $pendingPhotos = \App\Models\Photo::where('status', 'pending')->count();

                // Videos pendientes
                $pendingVideos = \App\Models\Video::where('status', 'pending')->count();

                // Streams activos
                $activeStreams = \App\Models\Stream::where('status', 'live')->count();

                $view->with([
                    'pendingProfilesCount' => $pendingCount,
                    'pendingPhotosCount' => $pendingPhotos,
                    'pendingVideosCount' => $pendingVideos,
                    'activeStreamsCount' => $activeStreams
                ]);
            } catch (\Exception $e) {
                // Silently bypass if there are database issues during initial boot
            }
        });
        // Sidebar progress data for fans
        \Illuminate\Support\Facades\View::composer('components.sidebar-premium', function ($view) {
            $user = auth()->user();
            if ($user && $user->role === 'fan') {
                $progress = $user->progress;
                $currentLevel = $progress ? $progress->currentLevel : null;

                // Fix: Same logic as DashboardController
                if ($currentLevel) {
                    $nextLevel = \App\Models\Level::where('level_number', $currentLevel->level_number + 1)->first();
                } else {
                    $nextLevel = \App\Models\Level::orderBy('level_number', 'asc')->first();
                }

                $currentXP = $progress ? $progress->current_xp : 0;
                // Target is next level XP, fallback to current if max level
                $requiredXP = $nextLevel ? $nextLevel->xp_required : ($currentLevel ? $currentLevel->xp_required : 0);

                // Use the centralized method for percentage
                $xpPercentage = $user->getXPPercentage();

                // Obtener todos los idiomas definidos en las traducciones
                $activeLanguages = array_keys(__('model.options.languages'));

                $view->with([
                    'sidebarProgress' => $progress,
                    'sidebarLevel' => $currentLevel ?? $nextLevel,
                    'sidebarNextLevel' => $nextLevel,
                    'sidebarXpPercentage' => $xpPercentage,
                    'sidebarCurrentXP' => $currentXP,
                    'sidebarRequiredXP' => $requiredXP,
                    'activeLanguages' => $activeLanguages
                ]);
            } else {
                // Para visitantes o modelos, también compartimos idiomas si es necesario
                $activeLanguages = array_keys(__('model.options.languages'));
                
                $view->with('activeLanguages', $activeLanguages);
            }

            // Share active streams count for all users (guests included)
            $activeStreamsCount = \App\Models\Stream::where('status', 'live')->count();
            $view->with('activeStreamsCount', $activeStreamsCount);
        });
    }
}
