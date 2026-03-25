<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class VerifyUnifiedHeaders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:unified-headers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar que todas las vistas usen el header unificado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando uso del header unificado...');
        
        // Buscar todas las vistas que podrían tener headers
        $viewsDirectory = resource_path('views');
        $allViews = File::allFiles($viewsDirectory);
        
        $unifiedCount = 0;
        $oldHeaderCount = 0;
        $noHeaderCount = 0;
        
        $this->info('📄 Analizando vistas:');
        
        foreach ($allViews as $file) {
            if ($file->getExtension() === 'php') {
                $relativePath = str_replace($viewsDirectory . DIRECTORY_SEPARATOR, '', $file->getPathname());
                $relativePath = str_replace('\\', '/', $relativePath);
                
                // Saltar componentes y layouts
                if (strpos($relativePath, 'components/') === 0 || 
                    strpos($relativePath, 'layouts/') === 0) {
                    continue;
                }
                
                $content = File::get($file->getPathname());
                
                // Verificar si usa header unificado
                if (strpos($content, "@include('components.header-unified')") !== false) {
                    $this->info("   ✅ {$relativePath}: Usa header unificado");
                    $unifiedCount++;
                }
                // Verificar si tiene header antiguo
                elseif (strpos($content, 'header-premium') !== false && 
                        strpos($content, '<header class="header-premium"') !== false) {
                    $this->warn("   ⚠️  {$relativePath}: Usa header antiguo");
                    $oldHeaderCount++;
                }
                // Verificar si es una vista principal sin header
                elseif (strpos($content, '<body>') !== false && 
                        strpos($content, 'header') === false &&
                        !in_array($relativePath, ['errors/404.blade.php', 'errors/500.blade.php'])) {
                    $this->comment("   ℹ️  {$relativePath}: Sin header");
                    $noHeaderCount++;
                }
            }
        }
        
        $this->newLine();
        $this->info('📊 Estadísticas del header:');
        $this->info("   • Vistas con header unificado: {$unifiedCount}");
        $this->info("   • Vistas con header antiguo: {$oldHeaderCount}");
        $this->info("   • Vistas sin header: {$noHeaderCount}");
        
        $this->newLine();
        $this->info('🎯 Verificando componente header-unified:');
        
        $headerUnifiedPath = resource_path('views/components/header-unified.blade.php');
        if (File::exists($headerUnifiedPath)) {
            $headerContent = File::get($headerUnifiedPath);
            
            // Verificar elementos clave del header
            $checks = [
                'hamburger-btn' => 'Botón hamburguesa',
                'search-models' => 'Componente de búsqueda',
                'nav-menu' => 'Menú de navegación',
                'fas fa-gem' => 'Logo con ícono',
                'toggleSidebar()' => 'Función toggle sidebar'
            ];
            
            foreach ($checks as $element => $description) {
                if (strpos($headerContent, $element) !== false) {
                    $this->info("   ✅ {$description}: Presente");
                } else {
                    $this->warn("   ⚠️  {$description}: Faltante");
                }
            }
        } else {
            $this->error('   ❌ Componente header-unified no encontrado');
        }
        
        $this->newLine();
        if ($oldHeaderCount === 0) {
            $this->info('🎉 ¡Todas las vistas usan el header unificado!');
            $this->info('✅ Migración completada exitosamente');
        } else {
            $this->warn("⚠️  Aún hay {$oldHeaderCount} vistas con header antiguo");
            $this->info('💡 Ejecuta: php artisan update:headers-unified');
        }
        
        return Command::SUCCESS;
    }
}
