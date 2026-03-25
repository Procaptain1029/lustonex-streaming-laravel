<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class GamificationXpSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            // Fan
            'gamification.xp.fan_tip_sent'           => 10,
            'gamification.xp.fan_subscription'       => 100,
            'gamification.xp.fan_chat_message'       => 1,
            'gamification.xp.fan_stream_view'        => 5,
            'gamification.xp.fan_tokens_purchased'   => 10,

            // Model
            'gamification.xp.model_tip_received'     => 10,
            'gamification.xp.model_new_subscriber'   => 50,
            'gamification.xp.model_chat_message'     => 1,
            'gamification.xp.model_stream_view'      => 5,
        ];

        foreach ($defaults as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $this->command->info('✅ XP Settings seeded (gamification.xp.*)');
    }
}
