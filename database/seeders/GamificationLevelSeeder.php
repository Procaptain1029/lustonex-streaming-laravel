<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class GamificationLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Niveles 0-21 según gamificacion.md
     */
    public function run(): void
    {
        $levels = [
            // === LIGA GRIS (0) ===
            [
                'level_number' => 0, 
                'name' => 'Liga Gris', 
                'xp_required' => 0,
                'rewards_json' => ['title' => 'Navegación básica']
            ],
            
            // === LIGA VERDE (1-5) ===
            [
                'level_number' => 1, 
                'name' => 'Liga Verde', 
                'xp_required' => 100, // Compra inicial (100 tokens)
                'rewards_json' => ['title' => 'Emblema Verde', 'unlocks' => ['friend_requests', 'basic_emojis']]
            ],
            [
                'level_number' => 2, 
                'name' => 'Liga Verde', 
                'xp_required' => 75,
                'rewards_json' => ['tokens' => 20] // Example token reward
            ],
            [
                'level_number' => 3, 
                'name' => 'Liga Verde', 
                'xp_required' => 150,
                'rewards_json' => ['tokens' => 30]
            ],
            [
                'level_number' => 4, 
                'name' => 'Liga Verde', 
                'xp_required' => 300,
                'rewards_json' => ['tokens' => 40]
            ],
            [
                'level_number' => 5, 
                'name' => 'Liga Verde', 
                'xp_required' => 600,
                'rewards_json' => ['tokens' => 50]
            ],
            
            // === LIGA BRONCE (6-10) ===
            [
                'level_number' => 6, 
                'name' => 'Liga Bronce', 
                'xp_required' => 1200,
                'rewards_json' => ['title' => 'Emblema Bronce', 'unlocks' => ['albums', 'pm_photos'], 'tokens' => 60]
            ],
            [
                'level_number' => 7, 
                'name' => 'Liga Bronce', 
                'xp_required' => 2400,
                'rewards_json' => ['tokens' => 70]
            ],
            [
                'level_number' => 8, 
                'name' => 'Liga Bronce', 
                'xp_required' => 4000,
                'rewards_json' => ['tokens' => 80]
            ],
            [
                'level_number' => 9, 
                'name' => 'Liga Bronce', 
                'xp_required' => 6000,
                'rewards_json' => ['tokens' => 90]
            ],
            [
                'level_number' => 10, 
                'name' => 'Liga Bronce', 
                'xp_required' => 9000,
                'rewards_json' => ['tokens' => 100]
            ],
            
            // === LIGA ORO (11-15) ===
            [
                'level_number' => 11, 
                'name' => 'Liga Oro', 
                'xp_required' => 13000,
                'rewards_json' => ['title' => 'Emblema Oro', 'unlocks' => ['emblem_protection'], 'tokens' => 150]
            ],
            [
                'level_number' => 12, 
                'name' => 'Liga Oro', 
                'xp_required' => 18000,
                'rewards_json' => ['tokens' => 200]
            ],
            [
                'level_number' => 13, 
                'name' => 'Liga Oro', 
                'xp_required' => 24000,
                'rewards_json' => ['tokens' => 250]
            ],
            [
                'level_number' => 14, 
                'name' => 'Liga Oro', 
                'xp_required' => 32000,
                'rewards_json' => ['tokens' => 300]
            ],
            [
                'level_number' => 15, 
                'name' => 'Liga Oro', 
                'xp_required' => 42000,
                'rewards_json' => ['tokens' => 400]
            ],
            
            // === LIGA DIAMANTE (16-20) ===
            [
                'level_number' => 16, 
                'name' => 'Liga Diamante', 
                'xp_required' => 56000,
                'rewards_json' => ['title' => 'Emblema Diamante', 'unlocks' => ['invisible_mode', 'private_tips'], 'tokens' => 500]
            ],
            [
                'level_number' => 17, 
                'name' => 'Liga Diamante', 
                'xp_required' => 72000,
                'rewards_json' => ['tokens' => 600]
            ],
            [
                'level_number' => 18, 
                'name' => 'Liga Diamante', 
                'xp_required' => 92000,
                'rewards_json' => ['tokens' => 700]
            ],
            [
                'level_number' => 19, 
                'name' => 'Liga Diamante', 
                'xp_required' => 116000,
                'rewards_json' => ['tokens' => 800]
            ],
            [
                'level_number' => 20, 
                'name' => 'Liga Diamante', 
                'xp_required' => 144000,
                'rewards_json' => ['tokens' => 1000]
            ],
            
            // === LIGA ELITE (21) ===
            [
                'level_number' => 21, 
                'name' => 'Liga Elite', 
                'xp_required' => 200000,
                'rewards_json' => [
                    'title' => 'Emblema Elite', 
                    'unlocks' => ['black_membership_free', 'cashback_1_percent'],
                    'tokens' => 5000
                ]
            ],
        ];

        foreach ($levels as $levelData) {
            Level::updateOrCreate(
                ['level_number' => $levelData['level_number']],
                [
                    'name' => $levelData['name'],
                    'xp_required' => $levelData['xp_required'],
                    'rewards_json' => $levelData['rewards_json'] // Model handles casting array to json
                ]
            );
        }
    }
}
