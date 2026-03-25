<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;

class InteractionSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Get IDs
        $this->command->info("🔄 Fetching user IDs...");
        $modelIds = DB::table('users')->where('role', 'model')->pluck('id')->toArray();
        $fanIds = DB::table('users')->where('role', 'fan')->pluck('id')->toArray();
        
        if (empty($modelIds) || empty($fanIds)) {
            $this->command->error("❌ Models or Fans missing. Run ModelSeeder and FanSeeder first.");
            return;
        }

        // ==========================================
        // 1. SUBSCRIPTIONS
        // ==========================================
        $this->command->info("🌱 Seeding Subscriptions...");
        $subscriptions = [];
        // Each fan subscribes to 1-5 models
        foreach ($fanIds as $fanId) {
            $numSubs = rand(0, 3); // some fans have 0 subs
            if ($numSubs > 0) {
                $randomModels = $faker->randomElements($modelIds, $numSubs);
                foreach ($randomModels as $modelId) {
                    $subscriptions[] = [
                        'fan_id' => $fanId,
                        'model_id' => $modelId,
                        'status' => 'active',
                        'starts_at' => now()->subDays(rand(1, 30)),
                        'expires_at' => now()->addDays(rand(1, 30)),
                        'amount' => $faker->randomElement([9.99, 14.99, 19.99]),
                        'tier' => 'Fan',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            
            // Batch insert to avoid memory issues
            if (count($subscriptions) >= 1000) {
                DB::table('subscriptions')->insertOrIgnore($subscriptions);
                $subscriptions = [];
            }
        }
        if (!empty($subscriptions)) {
            DB::table('subscriptions')->insertOrIgnore($subscriptions);
        }
        
        // ==========================================
        // 2. LIKES (on Photos)
        // ==========================================
        $this->command->info("🌱 Seeding Likes...");
        // Get some photo IDs
        $photoIds = DB::table('photos')->limit(50000)->pluck('id')->toArray(); // Fetch a chunk
        
        $likes = [];
        foreach ($fanIds as $fanId) {
            if (rand(0, 1)) continue; // 50% chance active fan
            
            $numLikes = rand(1, 10);
            $randomPhotos = $faker->randomElements($photoIds, $numLikes);
            
            foreach ($randomPhotos as $photoId) {
                $likes[] = [
                    'user_id' => $fanId,
                    'likeable_id' => $photoId,
                    'likeable_type' => 'App\Models\Photo',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (count($likes) >= 1000) {
                DB::table('likes')->insertOrIgnore($likes);
                $likes = [];
            }
        }
        if (!empty($likes)) {
            DB::table('likes')->insertOrIgnore($likes);
        }

        // ==========================================
        // 3. TIPS
        // ==========================================
        $this->command->info("🌱 Seeding Tips...");
        $tips = [];
        $tipCount = 0;
        // Random tips from fans to models
        for ($k = 0; $k < 5000; $k++) {
            $tips[] = [
                'fan_id' => $faker->randomElement($fanIds),
                'model_id' => $faker->randomElement($modelIds),
                'amount' => $faker->randomElement([10, 50, 100, 200, 500, 1000]),
                'message' => $faker->optional()->sentence,
                'status' => 'completed',
                'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
                'updated_at' => now(),
            ];

            if (count($tips) >= 1000) {
                DB::table('tips')->insert($tips);
                $tips = [];
            }
        }
        if (!empty($tips)) {
            DB::table('tips')->insert($tips);
        }

        $this->command->info("✅ Interactions seeded!");
    }
}
