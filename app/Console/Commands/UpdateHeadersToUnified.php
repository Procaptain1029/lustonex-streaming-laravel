<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UpdateHeadersToUnified extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:headers-unified';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar todas las vistas para usar el header unificado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Actualizando headers a componente unificado...');
        
        // Archivos que necesitan actualización
        $viewsToUpdate = [
            'search/results.blade.php',
            'profiles/show.blade.php',
            'auth/login.blade.php',
            'fan/dashboard.blade.php',
            'model/profile/edit.blade.php',
            'auth/register-model.blade.php',
            'model/dashboard.blade.php',
            'fan/subscriptions/index.blade.php',
            'model/videos/create.blade.php',
            'fan/tokens/history.blade.php',
            'model/streams/create.blade.php',
            'model/photos/create.blade.php',
            'model/videos/index.blade.php',
            'auth/register.blade.php',
            'model/streams/index.blade.php',
            'model/photos/index.blade.php',
            'fan/tokens/index.blade.php',
            'model/streams/show.blade.php',
            'fan/tokens/recharge.blade.php'
        ];
        
        $updatedCount = 0;
        $skippedCount = 0;
        
        foreach ($viewsToUpdate as $viewPath) {
            $fullPath = resource_path("views/{$viewPath}");
            
            if (File::exists($fullPath)) {
                $content = File::get($fullPath);
                
                // Buscar el header completo y reemplazarlo
                $headerPattern = '/<!-- Header.*?<\/header>/s';
                
                if (preg_match($headerPattern, $content)) {
                    // Reemplazar con el include del componente unificado
                    $newContent = preg_replace($headerPattern, "@include('components.header-unified')", $content);
                    
                    File::put($fullPath, $newContent);
                    $this->info("   ✅ Actualizado: {$viewPath}");
                    $updatedCount++;
                } else {
                    $this->warn("   ⚠️  No se encontró header en: {$viewPath}");
                    $skippedCount++;
                }
            } else {
                $this->error("   ❌ Archivo no encontrado: {$viewPath}");
                $skippedCount++;
            }
        }
        
        $this->newLine();
        $this->info('📊 Resumen de actualización:');
        $this->info("   • Archivos actualizados: {$updatedCount}");
        $this->info("   • Archivos omitidos: {$skippedCount}");
        
        $this->newLine();
        $this->info('🎯 Beneficios del header unificado:');
        $this->info('   • Consistencia visual en toda la aplicación');
        $this->info('   • Mantenimiento centralizado del header');
        $this->info('   • Funcionalidad uniforme del menú hamburguesa');
        $this->info('   • Búsqueda disponible en todas las páginas');
        $this->info('   • Navegación consistente según roles de usuario');
        
        return Command::SUCCESS;
    }
}
