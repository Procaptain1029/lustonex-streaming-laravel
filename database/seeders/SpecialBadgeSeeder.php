<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SpecialBadge;

class SpecialBadgeSeeder extends Seeder
{
    public function run()
    {
        $badges = [
            [
                'name' => 'Hall of Fame',
                'slug' => 'hall-of-fame',
                'description' => 'Top 10 del mes en el ranking',
                'icon' => 'fa-trophy',
                'color' => '#FFD700',
                'type' => 'hall_of_fame',
                'requirements' => ['rank' => 10],
                'is_active' => true,
            ],
            [
                'name' => 'Rising Star',
                'slug' => 'rising-star',
                'description' => 'Mayor crecimiento del mes',
                'icon' => 'fa-star',
                'color' => '#FF6B6B',
                'type' => 'milestone',
                'requirements' => ['growth_percentage' => 50],
                'is_active' => true,
            ],
            [
                'name' => 'Diamond Model',
                'slug' => 'diamond-model',
                'description' => 'Alcanzó el nivel 21 (Diamante)',
                'icon' => 'fa-gem',
                'color' => '#4ECDC4',
                'type' => 'milestone',
                'requirements' => ['level' => 21],
                'is_active' => true,
            ],
            [
                'name' => 'Hot Streak',
                'slug' => 'hot-streak',
                'description' => '30 días consecutivos activa',
                'icon' => 'fa-fire',
                'color' => '#FF4757',
                'type' => 'special',
                'requirements' => ['consecutive_days' => 30],
                'is_active' => true,
            ],
            [
                'name' => 'Queen of Hearts',
                'slug' => 'queen-of-hearts',
                'description' => 'Más propinas recibidas del mes',
                'icon' => 'fa-heart',
                'color' => '#FF69B4',
                'type' => 'hall_of_fame',
                'requirements' => ['top_tips' => true],
                'is_active' => true,
            ],
            [
                'name' => 'Content Creator',
                'slug' => 'content-creator',
                'description' => 'Subió más de 100 fotos',
                'icon' => 'fa-camera',
                'color' => '#9B59B6',
                'type' => 'milestone',
                'requirements' => ['photos' => 100],
                'is_active' => true,
            ],
            [
                'name' => 'Live Queen',
                'slug' => 'live-queen',
                'description' => 'Más de 50 streams realizados',
                'icon' => 'fa-video',
                'color' => '#3498DB',
                'type' => 'milestone',
                'requirements' => ['streams' => 50],
                'is_active' => true,
            ],
            [
                'name' => 'Fan Favorite',
                'slug' => 'fan-favorite',
                'description' => 'Más de 100 suscriptores activos',
                'icon' => 'fa-users',
                'color' => '#1ABC9C',
                'type' => 'milestone',
                'requirements' => ['subscribers' => 100],
                'is_active' => true,
            ],
        ];

        foreach ($badges as $badge) {
            SpecialBadge::updateOrCreate(
                ['slug' => $badge['slug']], // search criteria
                $badge // update/create values
            );
        }
    }
}
