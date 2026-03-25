<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UnifyAllScripts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unify:all-scripts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unificar todos los scripts de sidebar y header en componentes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Unificando scripts en todas las vistas...');
        
        // Buscar todas las vistas que usan header-unified
        $viewsDirectory = resource_path('views');
        $allViews = File::allFiles($viewsDirectory);
        
        $updatedCount = 0;
        $skippedCount = 0;
        
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
                
                // Solo procesar vistas que usan header-unified
                if (strpos($content, "@include('components.header-unified')") !== false) {
                    
                    // Verificar si ya tiene los scripts unificados
                    if (strpos($content, "@include('components.sidebar-header-scripts')") !== false) {
                        $this->comment("   ℹ️  {$relativePath}: Ya tiene scripts unificados");
                        continue;
                    }
                    
                    // Buscar y reemplazar JavaScript duplicado
                    $patterns = [
                        // Patrón para función toggleSidebar completa
                        '/function toggleSidebar\(\)\s*\{[^}]*\}(?:\s*\})?/s',
                        // Patrón para función initializeSearch completa
                        '/function initializeSearch\(\)\s*\{[^}]*(?:\}[^}]*)*\}/s',
                        // Patrón para función performSearch completa
                        '/function performSearch\(\)\s*\{[^}]*(?:\}[^}]*)*\}/s',
                        // Patrón para handleOutsideClick
                        '/function handleOutsideClick\([^)]*\)\s*\{[^}]*\}/s',
                        // Patrón para event listeners de DOMContentLoaded que incluyan sidebar
                        '/document\.addEventListener\(\'DOMContentLoaded\'[^}]*(?:toggleSidebar|initializeSearch|handleOutsideClick)[^}]*\}\);?/s'
                    ];
                    
                    $newContent = $content;
                    $hasChanges = false;
                    
                    foreach ($patterns as $pattern) {
                        if (preg_match($pattern, $newContent)) {
                            $newContent = preg_replace($pattern, '', $newContent);
                            $hasChanges = true;
                        }
                    }
                    
                    // Agregar los includes de scripts unificados antes del cierre de body
                    if ($hasChanges) {
                        // Buscar el cierre de </body>
                        if (strpos($newContent, '</body>') !== false) {
                            $newContent = str_replace(
                                '</body>',
                                "\n    <!-- Scripts Unificados -->\n    @include('components.sidebar-header-scripts')\n    @include('components.search-scripts')\n</body>",
                                $newContent
                            );
                            
                            File::put($file->getPathname(), $newContent);
                            $this->info("   ✅ Actualizado: {$relativePath}");
                            $updatedCount++;
                        } else {
                            $this->warn("   ⚠️  No se encontró </body> en: {$relativePath}");
                            $skippedCount++;
                        }
                    } else {
                        $this->comment("   ℹ️  Sin cambios necesarios: {$relativePath}");
                    }
                }
            }
        }
        
        $this->newLine();
        $this->info('📊 Resumen de unificación:');
        $this->info("   • Archivos actualizados: {$updatedCount}");
        $this->info("   • Archivos omitidos: {$skippedCount}");
        
        $this->newLine();
        $this->info('🎯 Beneficios de la unificación:');
        $this->info('   • Scripts centralizados en componentes reutilizables');
        $this->info('   • Comportamiento consistente del header y sidebar');
        $this->info('   • Fácil mantenimiento y actualización');
        $this->info('   • Eliminación de código duplicado');
        $this->info('   • Header fijo en todas las páginas');
        
        return Command::SUCCESS;
    }
}
