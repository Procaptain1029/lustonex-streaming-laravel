<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class FanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $password = Hash::make('password');
        $avatars = [
            '2.jpeg', '3.jpeg', '10.jpg', '11.jpg', '12.jpg', '13.jpg', 
            '14.webp', '15.jpg', '16.jpg', '17.jpg', '18.jpg', '19.webp', 
            '20.jpg', '4.webp', '5.webp', '6.jpg', '7.jpg', '8.webp', '9.jpg'
        ];

        $totalFans = 10000;
        $batchSize = 1000; // Larger batch for fans as they have less related data

        $this->command->info("🌱 Seeding $totalFans fans...");
        $this->command->getOutput()->progressStart($totalFans);

        for ($i = 0; $i < $totalFans; $i += $batchSize) {
            $users = [];
            $profiles = [];
            $userProgress = [];
            
            $currentBatch = min($batchSize, $totalFans - $i);

            for ($j = 0; $j < $currentBatch; $j++) {
                $email = "fan_" . ($i + $j) . "@example.com";
                
                // 1. User
                $users[] = [
                    'name' => $faker->name,
                    'email' => $email,
                    'password' => $password,
                    'role' => 'fan',
                    'tokens' => $faker->numberBetween(100, 10000), // Fans have tokens to spend
                    'balance' => 0, // Fans don't usually earn money
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('users')->insert($users);
            
            $createdUsers = DB::table('users')
                ->whereIn('email', array_column($users, 'email'))
                ->pluck('id');

            foreach ($createdUsers as $userId) {
                // 2. Profile
                $profiles[] = [
                    'user_id' => $userId,
                    'display_name' => $faker->userName,
                    'bio' => $faker->sentence(5),
                    'avatar' => 'avatar/' . $faker->randomElement($avatars),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                // 3. User Progress
                $userProgress[] = [
                    'user_id' => $userId,
                    'current_xp' => $faker->numberBetween(0, 5000),
                    'total_xp' => $faker->numberBetween(0, 5000),
                    'tickets_balance' => $faker->numberBetween(0, 20),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('profiles')->insert($profiles);
            DB::table('user_progress')->insert($userProgress);

            $this->command->getOutput()->progressAdvance($currentBatch);
        }
        
        $this->command->getOutput()->progressFinish();
        
        $this->command->info("\n✅ 10000 Fans seeded!");
    }
}
