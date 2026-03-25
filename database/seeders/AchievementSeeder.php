<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    public function run()
    {
        $achievements = [
            // === FAN ACHIEVEMENTS - Common ===
            [
                'name' => 'Primera Suscripción',
                'slug' => 'first-subscription',
                'description' => 'Suscríbete a tu primera modelo',
                'icon' => 'fa-crown',
                'rarity' => 'common', 'category' => 'content', 'role' => 'fan',
                'requirements' => ['subscriptions' => 1],
                'xp_reward' => 50, 'ticket_reward' => 1,
            ],
            [
                'name' => 'Primera Propina',
                'slug' => 'first-tip',
                'description' => 'Envía tu primera propina',
                'icon' => 'fa-coins',
                'rarity' => 'common', 'category' => 'earnings', 'role' => 'fan',
                'requirements' => ['tips_sent' => 1],
                'xp_reward' => 30, 'ticket_reward' => 1,
            ],
            [
                'name' => 'Espectador Activo',
                'slug' => 'active-viewer',
                'description' => 'Mira 5 streams en vivo',
                'icon' => 'fa-eye',
                'rarity' => 'common', 'category' => 'content', 'role' => 'fan',
                'requirements' => ['streams_watched' => 5],
                'xp_reward' => 100, 'ticket_reward' => 2,
            ],
            [ 
                'name' => 'Fan Leal',
                'slug' => 'fan-leal',
                'description' => 'Sigue a 10 modelos',
                'icon' => 'fa-heart',
                'rarity' => 'common', 'category' => 'popularity', 'role' => 'fan',
                'requirements' => ['following' => 10],
                'xp_reward' => 200, 'ticket_reward' => 2,
            ],

            // === FAN ACHIEVEMENTS - Rare ===
            [
                'name' => 'Coleccionista',
                'slug' => 'collector',
                'description' => 'Suscríbete a 5 modelos diferentes',
                'icon' => 'fa-star',
                'rarity' => 'rare', 'category' => 'content', 'role' => 'fan',
                'requirements' => ['subscriptions' => 5],
                'xp_reward' => 200, 'ticket_reward' => 5,
            ],
            [
                'name' => 'Generoso',
                'slug' => 'generous',
                'description' => 'Envía 1000 tokens en propinas',
                'icon' => 'fa-gift',
                'rarity' => 'rare', 'category' => 'earnings', 'role' => 'fan',
                'requirements' => ['total_tips' => 1000],
                'xp_reward' => 300, 'ticket_reward' => 10,
            ],

            // === FAN ACHIEVEMENTS - Epic / Legendary ===
            [
                'name' => 'Super Fan',
                'slug' => 'super-fan',
                'description' => 'Mantén 10 suscripciones activas',
                'icon' => 'fa-fire',
                'rarity' => 'epic', 'category' => 'popularity', 'role' => 'fan',
                'requirements' => ['active_subscriptions' => 10],
                'xp_reward' => 500, 'ticket_reward' => 20,
            ],
            [
                'name' => 'Mecenas',
                'slug' => 'patron',
                'description' => 'Envía 10,000 tokens en propinas',
                'icon' => 'fa-gem',
                'rarity' => 'legendary', 'category' => 'earnings', 'role' => 'fan',
                'requirements' => ['total_tips' => 10000],
                'xp_reward' => 1000, 'ticket_reward' => 50,
            ],

            // === MODEL ACHIEVEMENTS - Common ===
            [
                'name' => 'Primera Foto',
                'slug' => 'first-photo',
                'description' => 'Sube tu primera foto',
                'icon' => 'fa-camera',
                'rarity' => 'common', 'category' => 'content', 'role' => 'model',
                'requirements' => ['photos_uploaded' => 1],
                'xp_reward' => 50, 'ticket_reward' => 1,
            ],
            [
                'name' => 'Primera Transmisión',
                'slug' => 'first-stream',
                'description' => 'Realiza tu primera transmisión en vivo',
                'icon' => 'fa-video',
                'rarity' => 'common', 'category' => 'content', 'role' => 'model',
                'requirements' => ['streams_done' => 1],
                'xp_reward' => 100, 'ticket_reward' => 2,
            ],
            [
                'name' => 'Primera Propina Recibida',
                'slug' => 'first-tip-received',
                'description' => 'Recibe tu primera propina',
                'icon' => 'fa-coins',
                'rarity' => 'common', 'category' => 'earnings', 'role' => 'model',
                'requirements' => ['tips_received' => 1],
                'xp_reward' => 50, 'ticket_reward' => 1,
            ],

            // === MODEL ACHIEVEMENTS - Rare ===
            [
                'name' => 'Creadora de Contenido',
                'slug' => 'content-creator',
                'description' => 'Sube 50 fotos o videos',
                'icon' => 'fa-images',
                'rarity' => 'rare', 'category' => 'content', 'role' => 'model',
                'requirements' => ['content_uploaded' => 50],
                'xp_reward' => 400, 'ticket_reward' => 4,
            ],
            [
                'name' => 'Estrella Naciente',
                'slug' => 'estrella-naciente',
                'description' => 'Alcanza 100 seguidores',
                'icon' => 'fa-star',
                'rarity' => 'rare', 'category' => 'popularity', 'role' => 'model',
                'requirements' => ['followers' => 100],
                'xp_reward' => 500, 'ticket_reward' => 5,
            ],
            [
                'name' => 'Maratonista',
                'slug' => 'maratonista',
                'description' => 'Transmite durante 10 horas en total',
                'icon' => 'fa-clock',
                'rarity' => 'rare', 'category' => 'content', 'role' => 'model',
                'requirements' => ['stream_hours' => 10],
                'xp_reward' => 750, 'ticket_reward' => 7,
            ],

            // === MODEL ACHIEVEMENTS - Epic / Legendary ===
            [
                'name' => 'Popular',
                'slug' => 'popular',
                'description' => 'Alcanza 500 seguidores',
                'icon' => 'fa-fire',
                'rarity' => 'epic', 'category' => 'popularity', 'role' => 'model',
                'requirements' => ['followers' => 500],
                'xp_reward' => 1000, 'ticket_reward' => 10,
            ],
            [
                'name' => 'Millonaria',
                'slug' => 'millonaria',
                'description' => 'Gana $1000 USD (o eq. tokens) en total',
                'icon' => 'fa-dollar-sign',
                'rarity' => 'legendary', 'category' => 'earnings', 'role' => 'model',
                'requirements' => ['earnings' => 1000],
                'xp_reward' => 2000, 'ticket_reward' => 20,
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::updateOrCreate(
                ['slug' => $achievement['slug']], 
                array_merge($achievement, ['is_active' => true])
            );
        }
    }
}
