<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;

class FixProfileJsonFields extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:profile-json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix JSON fields in profiles that may be stored as strings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Corrigiendo campos JSON en perfiles...');
        
        $profiles = Profile::all();
        $fixed = 0;
        
        foreach ($profiles as $profile) {
            $needsUpdate = false;
            $updates = [];
            
            // Corregir languages
            if ($profile->languages && is_string($profile->languages)) {
                $decoded = json_decode($profile->languages, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $updates['languages'] = $decoded;
                    $needsUpdate = true;
                }
            }
            
            // Corregir specific_details
            if ($profile->specific_details && is_string($profile->specific_details)) {
                $decoded = json_decode($profile->specific_details, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $updates['specific_details'] = $decoded;
                    $needsUpdate = true;
                }
            }
            
            // Corregir interests
            if ($profile->interests && is_string($profile->interests)) {
                $decoded = json_decode($profile->interests, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $updates['interests'] = $decoded;
                    $needsUpdate = true;
                }
            }
            
            // Corregir social_networks
            if ($profile->social_networks && is_string($profile->social_networks)) {
                $decoded = json_decode($profile->social_networks, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $updates['social_networks'] = $decoded;
                    $needsUpdate = true;
                }
            }
            
            if ($needsUpdate) {
                DB::table('profiles')
                    ->where('id', $profile->id)
                    ->update($updates);
                $fixed++;
            }
        }
        
        $this->info("✅ Se corrigieron {$fixed} perfiles de {$profiles->count()} totales.");
        
        // Verificar que todo esté funcionando
        $this->info('🧪 Probando los métodos de acceso...');
        
        $testProfile = Profile::first();
        if ($testProfile) {
            try {
                $languages = $testProfile->languages_list;
                $interests = $testProfile->interests_list;
                $details = $testProfile->specific_details_list;
                $networks = $testProfile->social_networks_list;
                
                $this->info('✅ Todos los métodos funcionan correctamente.');
                $this->info("Ejemplo - Idiomas: {$languages}");
                $this->info("Ejemplo - Intereses: {$interests}");
            } catch (\Exception $e) {
                $this->error('❌ Error al probar los métodos: ' . $e->getMessage());
            }
        }
        
        return Command::SUCCESS;
    }
}
