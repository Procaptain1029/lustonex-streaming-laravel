<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Profile;

class TestAvatarUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:avatar-urls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test avatar URLs and verify image paths';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🖼️  Verificando URLs de avatares...');
        
        $profiles = Profile::take(5)->get();
        
        if ($profiles->isEmpty()) {
            $this->error('❌ No se encontraron perfiles.');
            return Command::FAILURE;
        }
        
        foreach ($profiles as $profile) {
            $this->info("👤 {$profile->display_name}:");
            $this->info("   Avatar campo: {$profile->avatar}");
            $this->info("   Avatar URL: {$profile->avatar_url}");
            
            // Verificar si el archivo existe
            $avatarPath = public_path(str_replace(url('/'), '', $profile->avatar_url));
            $exists = file_exists($avatarPath);
            
            $this->info("   Ruta física: {$avatarPath}");
            $this->info("   Existe: " . ($exists ? '✅ Sí' : '❌ No'));
            $this->newLine();
        }
        
        // Verificar carpeta de avatares
        $avatarDir = public_path('avatar');
        $this->info("📁 Carpeta de avatares: {$avatarDir}");
        $this->info("   Existe: " . (is_dir($avatarDir) ? '✅ Sí' : '❌ No'));
        
        if (is_dir($avatarDir)) {
            $files = glob($avatarDir . '/*');
            $this->info("   Archivos encontrados: " . count($files));
            
            foreach (array_slice($files, 0, 5) as $file) {
                $this->info("   - " . basename($file));
            }
        }
        
        return Command::SUCCESS;
    }
}
