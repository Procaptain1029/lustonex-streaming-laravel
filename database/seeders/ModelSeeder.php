<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\User;

class ModelSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $password = Hash::make('password'); // Pre-hash for performance
        $avatars = [
            '2.jpeg', '3.jpeg', '10.jpg', '11.jpg', '12.jpg', '13.jpg', 
            '14.webp', '15.jpg', '16.jpg', '17.jpg', '18.jpg', '19.webp', 
            '20.jpg', '4.webp', '5.webp', '6.jpg', '7.jpg', '8.webp', '9.jpg'
        ];

        // Specific fields choices for realistic data
        $countries = ['US', 'ES', 'MX', 'CO', 'AR', 'BR', 'UK', 'FR', 'DE', 'IT'];
        $languages = ['en', 'es', 'pt', 'fr', 'de', 'ja', 'it', 'ru'];
        $interestedIn = ['Todos', 'Hombres', 'Mujeres', 'Parejas'];
        $bodyTypes = ['Delgado', 'Atlético', 'Curvilíneo', 'Musculoso', 'Normal', 'Tatuado', 'Piercing'];
        $specificDetails = ['Tatuajes', 'Piercings', 'Cabello Corto', 'Cabello Largo', 'Gafas', 'Pecas'];
        $ethnicities = ['Blanca', 'Latina', 'Negra', 'Asiática', 'Mestiza', 'Indígena', 'Otra'];
        $hairColors = ['Moreno', 'Rubio', 'Pelirrojo', 'Castaño', 'Negro', 'Teñido'];
        $eyeColors = ['Café', 'Azul', 'Verde', 'Miel', 'Gris', 'Negro'];
        $subcultures = ['Estudiante', 'Profesional', 'Universitaria', 'Gamer', 'Otaku', 'Gótica', 'Indie', 'Fitness'];
        $interests = ['BDSM', 'Rol', 'Juguetes', 'Cosplay', 'Dominación', 'Sumisión', 'Pies', 'ASMR'];
        $socialNetworks = ['Twitter', 'Instagram', 'TikTok', 'Snapchat', 'Reddit'];
        $idDocumentTypes = ['cedula', 'pasaporte', 'licencia_conducir', 'identificacion_nacional'];

        $totalModels = 500;
        $batchSize = 250; // Reduced batch size slightly due to larger array sizes per insert

        $this->command->info("🌱 Seeding $totalModels models...");
        $this->command->getOutput()->progressStart($totalModels);

        for ($i = 0; $i < $totalModels; $i += $batchSize) {
            $users = [];
            $profiles = [];
            $photos = [];
            $userProgress = [];
            
            $currentBatch = min($batchSize, $totalModels - $i);

            for ($j = 0; $j < $currentBatch; $j++) {
                $email = "model_" . ($i + $j) . "@example.com";
                
                // 1. User
                $users[] = [
                    'name' => $faker->name('female'),
                    'email' => $email,
                    'password' => $password,
                    'role' => 'model',
                    'tokens' => $faker->numberBetween(0, 5000),
                    'balance' => $faker->randomFloat(2, 0, 1000),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert Users and get IDs
            DB::table('users')->insert($users);
            
            // Fetch the just created users to get their IDs
            $createdUsers = DB::table('users')
                ->whereIn('email', array_column($users, 'email'))
                ->pluck('id');

            foreach ($createdUsers as $userId) {
                // Generate varied JSON arrays to mimic actual user input
                $modelLangs = json_encode($faker->randomElements($languages, rand(1, 3)));
                $modelSpecificDetails = json_encode($faker->randomElements($specificDetails, rand(0, 3)));
                $modelInterests = json_encode($faker->randomElements($interests, rand(2, 5)));
                
                $numSocials = rand(1, 3);
                $socialsData = [];
                $chosenNetworks = $faker->randomElements($socialNetworks, $numSocials);
                foreach ($chosenNetworks as $network) {
                    $socialsData[$network] = $faker->userName();
                }
                $modelSocialNetworks = json_encode($socialsData);

                // 2. Profile
                $profiles[] = [
                    'user_id' => $userId,
                    'display_name' => $faker->userName,
                    'bio' => $faker->sentence(10),
                    'avatar' => 'avatar/' . $faker->randomElement($avatars),
                    'cover_image' => 'avatar/' . $faker->randomElement($avatars), // Reusing avatars as covers for now
                    'subscription_price' => $faker->randomElement([9.99, 14.99, 19.99, 24.99, 4.99]),
                    'is_online' => $faker->boolean(20), // 20% online
                    'is_streaming' => false,
                    
                    // Detailed Fields
                    'country' => $faker->randomElement($countries),
                    'languages' => $modelLangs,
                    'age' => $faker->numberBetween(18, 55),
                    'interested_in' => $faker->randomElement($interestedIn),
                    'body_type' => $faker->randomElement($bodyTypes),
                    'specific_details' => $modelSpecificDetails,
                    'ethnicity' => $faker->randomElement($ethnicities),
                    'hair_color' => $faker->randomElement($hairColors),
                    'eye_color' => $faker->randomElement($eyeColors),
                    'subculture' => $faker->randomElement($subcultures),
                    'interests' => $modelInterests,
                    'social_networks' => $modelSocialNetworks,
                    
                    // Configuration Fields
                    'profile_completed' => true,
                    'last_profile_update' => now(),

                    // Verification Fields
                    'verification_status' => 'approved',
                    'id_document_front' => 'documents/dummy_front.jpg',
                    'id_document_back' => 'documents/dummy_back.jpg',
                    'id_document_type' => $faker->randomElement($idDocumentTypes),
                    'admin_notes' => 'Auto verified via seeder',
                    'rejection_reason' => null,
                    'verified_at' => now(),
                    'verified_by' => null, // Left null to avoid assuming an admin exists with ID 1
                    'step1_completed' => true,
                    'step2_completed' => true,
                    'step3_completed' => true,
                    'onboarding_completed_at' => now(),
                    
                    // Additional Onboarding Fields
                    'terms_accepted' => true,
                    'age_verified' => true,

                    // Pause Media Fields
                    'pause_image' => null,
                    'pause_video' => null,
                    'pause_mode' => 'none',

                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // 3. Gamification / User Progress Data
                $currentXp = $faker->numberBetween(0, 5000);
                $userProgress[] = [
                    'user_id' => $userId,
                    'current_xp' => $currentXp,
                    'total_xp' => $currentXp + $faker->numberBetween(0, 15000), // Total XP is always >= Current XP
                    'current_level_id' => null, // Assumes there's a command/job that calculates logic to set this later, or null is default
                    'tickets_balance' => $faker->numberBetween(0, 50),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // 4. Content (Photos) - 3 to 10 photos per model
                $numPhotos = rand(3, 10);
                for ($k = 0; $k < $numPhotos; $k++) {
                    $photos[] = [
                        'user_id' => $userId,
                        'title' => $faker->words(3, true),
                        'description' => $faker->sentence,
                        'path' => 'avatar/' . $faker->randomElement($avatars), // Reusing avatars
                        'is_public' => $faker->boolean(30), // 30% public
                        'status' => 'approved',
                        'views' => $faker->numberBetween(0, 1000),
                        'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                        'updated_at' => now(),
                    ];
                }
            }

            DB::table('profiles')->insert($profiles);
            DB::table('user_progress')->insert($userProgress);
            DB::table('photos')->insert($photos);

            $this->command->getOutput()->progressAdvance($currentBatch);
        }

        $this->command->getOutput()->progressFinish();
        
        $this->command->info("\n✅ $totalModels Models successfully seeded with advanced validation fields, demographics, and gamification data!");
    }
}
