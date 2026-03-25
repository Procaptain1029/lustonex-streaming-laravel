<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mission;

class MissionSeeder extends Seeder
{
    public function run(): void
    {
        // Helper to get level ID by number (compatible con campo role nuevo)
        $getLevelId = function ($number) {
            $level = \App\Models\Level::where('level_number', $number)->first();
            return $level ? $level->id : null;
        };

        // Helper to get achievement ID by slug
        $getAchievementId = function ($slug) {
            $achievement = \App\Models\Achievement::where('slug', $slug)->first();
            return $achievement ? $achievement->id : null;
        };

        $missions = [
            // === Misiones Obligatorias (LEVEL_UP) ===
            [
                'name'           => 'Realiza tu primera compra',
                'description'    => 'Compra tu primer paquete de Tokens para convertirte en Fan oficial.',
                'type'           => 'LEVEL_UP',
                'role'           => 'fan',
                'level_id'       => $getLevelId(0),
                'achievement_id' => $getAchievementId('primera-compra'),
                'target_action'  => 'first_purchase', 'goal_amount' => 1,
                'reward_xp'      => 10, 'reward_tickets' => 0
            ],
            [
                'name'           => 'Agrega a Favoritos',
                'description'    => 'Agrega al menos 1 modelo a tus favoritos.',
                'type'           => 'LEVEL_UP',
                'role'           => 'fan',
                'level_id'       => $getLevelId(1),
                'achievement_id' => null,
                'target_action'  => 'favorite_added', 'goal_amount' => 1,
                'reward_xp'      => 50, 'reward_tickets' => 1
            ],
            [
                'name' => 'Dar Like a contenido',
                'description' => 'Dale Me Gusta a una foto o video de cualquier modelo.',
                'type' => 'LEVEL_UP',
                'role' => 'fan',
                'level_id' => $getLevelId(2),
                'target_action' => 'like_content', 'goal_amount' => 1,
                'reward_xp' => 100, 'reward_tickets' => 1
            ],
            [
                'name' => 'Pagar acción del menú',
                'description' => 'Paga por una acción del menú de propinas de una modelo.',
                'type' => 'LEVEL_UP',
                'role' => 'fan',
                'level_id' => $getLevelId(3),
                'target_action' => 'tip_menu_item', 'goal_amount' => 1,
                'reward_xp' => 150, 'reward_tickets' => 2
            ],
            [
                'name' => 'Girar la Ruleta',
                'description' => 'Juega a la ruleta en la sala de cualquier modelo.',
                'type' => 'LEVEL_UP',
                'role' => 'fan',
                'level_id' => $getLevelId(4),
                'target_action' => 'spin_roulette', 'goal_amount' => 1,
                'reward_xp' => 200, 'reward_tickets' => 2
            ],
            [
                'name' => 'Agregar Amigo',
                'description' => 'Suscríbete a una modelo para desbloquear su contenido exclusivo y agregarla como amiga.',
                'type' => 'LEVEL_UP',
                'role' => 'fan',
                'level_id' => $getLevelId(5), // Required to reach Level 6
                'target_action' => 'subscribe_model', 'goal_amount' => 1,
                'reward_xp' => 300, 'reward_tickets' => 3
            ],
            [
                'name' => 'Apoyar Nuevas',
                'description' => 'Envía al menos 10 tokens a una modelo con etiqueta NEW.',
                'type' => 'LEVEL_UP',
                'role' => 'fan',
                'level_id' => $getLevelId(6),
                'target_action' => 'tip_new_model', 'goal_amount' => 10,
                'reward_xp' => 400, 'reward_tickets' => 4
            ],
            [
                'name' => 'Apoyar VIP',
                'description' => 'Envía al menos 25 tokens a una modelo con etiqueta VIP.',
                'type' => 'LEVEL_UP',
                'role' => 'fan',
                'level_id' => $getLevelId(7),
                'target_action' => 'tip_vip_model', 'goal_amount' => 25,
                'reward_xp' => 500, 'reward_tickets' => 5
            ],

            // === Misiones Semanales (WEEKLY) ===
             [
                'name' => 'Apoya a una New',
                'description' => 'Envía al menos 10 tokens a una modelo NEW.',
                'type' => 'WEEKLY',
                'role' => 'fan',
                'level_id' => null, // Available to all levels (or restrict if needed)
                'target_action' => 'tip_new_model_weekly',
                'goal_amount' => 10,
                'reward_xp' => 0,
                'reward_tickets' => 1,
            ],
          
            [
                'name' => 'Ver show público',
                'description' => 'Acumula 30 minutos viendo shows públicos.',
                'type' => 'WEEKLY',
                'role' => 'fan',
                'level_id' => null,
                'target_action' => 'watch_public_stream',
                'goal_amount' => 30, // minutes
                'reward_xp' => 0,
                'reward_tickets' => 1,
            ],
      
            [
                'name' => 'Girar la Ruleta Semanal',
                'description' => 'Realiza al menos 2 giros de ruleta.',
                'type' => 'WEEKLY',
                'role' => 'fan',
                'level_id' => null,
                'target_action' => 'spin_roulette_weekly',
                'goal_amount' => 2,
                'reward_xp' => 0,
                'reward_tickets' => 1,
            ],
             [
                'name' => 'Comprar Pack Tokens',
                'description' => 'Compra al menos 100 tokens durante la semana.',
                'type' => 'WEEKLY',
                'role' => 'fan',
                'level_id' => null,
                'target_action' => 'buy_tokens_weekly',
                'goal_amount' => 100,
                'reward_xp' => 0,
                'reward_tickets' => 3,
            ],
        ];

        // === Misiones para Modelos ===
        $modelMissions = [
             // LEVEL_UP
            [
                'name'           => 'Verificar Identidad',
                'description'    => 'Completa el proceso de verificación para empezar a transmitir.',
                'type'           => 'LEVEL_UP',
                'role'           => 'model',
                'level_id'       => $getLevelId(0),
                'achievement_id' => $getAchievementId('identidad-verificada'),
                'target_action'  => 'verify_identity',
                'goal_amount'    => 1,
                'reward_xp'      => 50,
                'reward_tickets' => 5,
            ],
            [
                'name'           => 'Primer Stream',
                'description'    => 'Realiza tu primera transmisión en vivo.',
                'type'           => 'LEVEL_UP',
                'role'           => 'model',
                'level_id'       => $getLevelId(1),
                'achievement_id' => $getAchievementId('primer-stream'),
                'target_action'  => 'first_stream',
                'goal_amount'    => 1,
                'reward_xp'      => 100,
                'reward_tickets' => 5,
            ],
            [
                'name' => 'Subir 5 Fotos',
                'description' => 'Sube al menos 5 fotos a tu perfil.',
                'type' => 'LEVEL_UP',
                'role' => 'model',
                'level_id' => $getLevelId(2),
                'target_action' => 'upload_photo',
                'goal_amount' => 5,
                'reward_xp' => 150,
                'reward_tickets' => 5,
            ],
            [
                'name' => 'Conseguir 100 Seguidores',
                'description' => 'Alcanza tus primeros 100 seguidores.',
                'type' => 'LEVEL_UP',
                'role' => 'model',
                'level_id' => $getLevelId(3),
                'target_action' => 'reach_followers',
                'goal_amount' => 100,
                'reward_xp' => 200,
                'reward_tickets' => 10,
            ],
            
            // WEEKLY
            [
                'name' => 'Meta de Tokens Semanal',
                'description' => 'Gana 1000 tokens en una semana.',
                'type' => 'WEEKLY',
                'role' => 'model',
                'level_id' => null,
                'target_action' => 'earn_tokens_weekly',
                'goal_amount' => 1000,
                'reward_xp' => 0,
                'reward_tickets' => 10,
            ],
            [
                'name' => 'Horas de Stream',
                'description' => 'Transmite durante 10 horas esta semana.',
                'type' => 'WEEKLY',
                'role' => 'model',
                'level_id' => null,
                'target_action' => 'stream_hours_weekly',
                'goal_amount' => 600, // minutes
                'reward_xp' => 0,
                'reward_tickets' => 15,
            ],
        ];

        $missions = array_merge($missions, $modelMissions);

        foreach ($missions as $mission) {
            Mission::updateOrCreate(
                ['name' => $mission['name']], 
                array_merge($mission, ['is_active' => true])
            );
        }
    }
}
