<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Profile;

class TestProfileMethods extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:profile-methods';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test all profile display methods';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Probando métodos de visualización de perfiles...');
        
        $profile = Profile::first();
        
        if (!$profile) {
            $this->error('❌ No se encontraron perfiles en la base de datos.');
            return Command::FAILURE;
        }
        
        $this->info("📋 Perfil de: {$profile->display_name}");
        $this->newLine();
        
        try {
            $this->info("🌍 País: {$profile->country_display}");
            $this->info("🎂 Edad: {$profile->age_display}");
            $this->info("💬 Idiomas: {$profile->languages_list}");
            $this->info("🎯 Intereses: {$profile->interests_list}");
            $this->info("📏 Detalles físicos: {$profile->specific_details_list}");
            $this->info("👤 Tipo de cuerpo: {$profile->body_type_display}");
            $this->info("🌈 Etnia: {$profile->ethnicity_display}");
            $this->info("💇‍♀️ Color de cabello: {$profile->hair_color_display}");
            $this->info("📱 Redes sociales: {$profile->social_networks_list}");
            
            $this->newLine();
            $this->info('✅ Todos los métodos funcionan correctamente!');
            
        } catch (\Exception $e) {
            $this->error('❌ Error al probar los métodos: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            return Command::FAILURE;
        }
        
        return Command::SUCCESS;
    }
}
