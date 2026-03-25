<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Achievement;
use App\Models\Mission;
use App\Models\Stream;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->command->info('🌱 Creando usuario administrador...');

        // ==========================================
        // 1. ADMIN
        // ==========================================
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@stream.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'tokens' => 0,
            'email_verified_at' => now(),
        ]);

        $admin->profile()->create([
            'bio' => 'Administrador del sistema',
            'avatar' => null,
        ]);

        $this->command->info('✅ Admin creado: admin@stream.com / password');

        $this->call(GamificationSeeder::class);

        $this->call([
            //MissionSeeder::class, 
            ModelSeeder::class,
            //FanSeeder::class,
            //InteractionSeeder::class,
        ]);

        // ==========================================
        // 6. RESUMEN FINAL
        // ==========================================
        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('✅ SEEDER COMPLETADO EXITOSAMENTE');
        $this->command->info('========================================');
      
    }
}
