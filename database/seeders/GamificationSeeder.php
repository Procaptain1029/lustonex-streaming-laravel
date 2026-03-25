<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GamificationSeeder extends Seeder
{
    /**
     * Seed the application's gamification system.
     */
    public function run(): void
    {
        $this->command->info('🎮 Starting Gamification Seeding...');

        // 1. Levels (con role e image)
        $this->call(GamificationLevelSeeder::class);
        $this->command->info('✅ Levels Seeded');

        // 2. Achievements (deben existir antes de Missions para poder linkarse)
        $this->call(AchievementSeeder::class);
        $this->command->info('✅ Achievements Seeded');

        // 3. Missions (LEVEL_UP, WEEKLY, PARALLEL — con achievement_id)
        $this->call(MissionSeeder::class);
        $this->command->info('✅ Missions Seeded');

        // 4. Special Badges (Hall of Fame, etc. — sin requirements técnicos)
        $this->call(SpecialBadgeSeeder::class);
        $this->command->info('✅ Special Badges Seeded');

        // 5. XP Settings globales en tabla settings
        $this->call(GamificationXpSettingsSeeder::class);
        $this->command->info('✅ XP Settings Seeded');

        $this->command->info('🚀 Gamification System Ready!');
    }
}
