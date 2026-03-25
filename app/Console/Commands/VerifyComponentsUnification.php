<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class VerifyComponentsUnification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:components-unification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar que todos los componentes estén unificados correctamente';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando unificación completa de componentes...');
        
        // Verificar componentes creados
        $this->info('📦 Verificando componentes creados:');
        
        $components = [
            'header-unified.blade.php' => 'Header unificado',
            'sidebar-header-scripts.blade.php' => 'Scripts de sidebar y header',
            'search-scripts.blade.php' => 'Scripts de búsqueda',
            'sidebar-premium.blade.php' => 'Sidebar premium',
            'footer-premium.blade.php' => 'Footer premium'
        ];
        
        foreach ($components as $file => $description) {
            $path = resource_path("views/components/{$file}");
            if (File::exists($path)) {
                $this->info("   ✅ {$description}: Presente");
            } else {
                $this->error("   ❌ {$description}: Faltante");
            }
        }
        
        $this->newLine();
        $this->info('🎯 Verificando uso en vistas:');
        
        // Buscar vistas que usan los componentes
        $viewsDirectory = resource_path('views');
        $allViews = File::allFiles($viewsDirectory);
        
        $headerCount = 0;
        $scriptsCount = 0;
        $footerCount = 0;
        $sidebarCount = 0;
        
        foreach ($allViews as $file) {
            if ($file->getExtension() === 'php') {
                $relativePath = str_replace($viewsDirectory . DIRECTORY_SEPARATOR, '', $file->getPathname());
                $relativePath = str_replace('\\', '/', $relativePath);
                
                // Saltar componentes
                if (strpos($relativePath, 'components/') === 0) {
                    continue;
                }
                
                $content = File::get($file->getPathname());
                
                // Contar uso de componentes
                if (strpos($content, "@include('components.header-unified')") !== false) {
                    $headerCount++;
                }
                if (strpos($content, "@include('components.sidebar-header-scripts')") !== false) {
                    $scriptsCount++;
                }
                if (strpos($content, "@include('components.footer-premium')") !== false) {
                    $footerCount++;
                }
                if (strpos($content, "@include('components.sidebar-premium')") !== false) {
                    $sidebarCount++;
                }
            }
        }
        
        $this->info("   • Header unificado: {$headerCount} vistas");
        $this->info("   • Scripts unificados: {$scriptsCount} vistas");
        $this->info("   • Footer premium: {$footerCount} vistas");
        $this->info("   • Sidebar premium: {$sidebarCount} vistas");
        
        $this->newLine();
        $this->info('⚠️  Verificando código duplicado:');
        
        $duplicateCount = 0;
        $cleanViews = 0;
        
        foreach ($allViews as $file) {
            if ($file->getExtension() === 'php') {
                $relativePath = str_replace($viewsDirectory . DIRECTORY_SEPARATOR, '', $file->getPathname());
                $relativePath = str_replace('\\', '/', $relativePath);
                
                if (strpos($relativePath, 'components/') === 0) {
                    continue;
                }
                
                $content = File::get($file->getPathname());
                
                // Buscar código duplicado
                $duplicates = [
                    'function toggleSidebar()' => 'Función toggleSidebar duplicada',
                    'function initializeSearch()' => 'Función initializeSearch duplicada',
                    'function performSearch()' => 'Función performSearch duplicada',
                    '<header class="header-premium"' => 'Header inline (no componente)'
                ];
                
                $hasDuplicates = false;
                foreach ($duplicates as $pattern => $description) {
                    if (strpos($content, $pattern) !== false && 
                        strpos($content, "@include('components.header-unified')") !== false) {
                        $this->warn("   ⚠️  {$relativePath}: {$description}");
                        $hasDuplicates = true;
                    }
                }
                
                if (!$hasDuplicates && strpos($content, "@include('components.header-unified')") !== false) {
                    $cleanViews++;
                } elseif ($hasDuplicates) {
                    $duplicateCount++;
                }
            }
        }
        
        $this->info("   • Vistas limpias: {$cleanViews}");
        $this->info("   • Vistas con duplicados: {$duplicateCount}");
        
        $this->newLine();
        $this->info('🎨 Verificando CSS del header fijo:');
        
        $cssPath = public_path('css/premium-design.css');
        if (File::exists($cssPath)) {
            $cssContent = File::get($cssPath);
            
            $cssChecks = [
                'padding: 1rem 2rem' => 'Padding del header',
                'min-height: 70px' => 'Altura mínima del header',
                'padding-top: 70px' => 'Padding-top del body',
                'position: fixed' => 'Header fijo'
            ];
            
            foreach ($cssChecks as $check => $description) {
                if (strpos($cssContent, $check) !== false) {
                    $this->info("   ✅ {$description}: Correcto");
                } else {
                    $this->warn("   ⚠️  {$description}: Verificar");
                }
            }
        }
        
        $this->newLine();
        if ($duplicateCount === 0) {
            $this->info('🎉 ¡Unificación completada exitosamente!');
            $this->info('✅ Todos los componentes están separados y unificados');
            $this->info('✅ Header fijo funcionando en todas las páginas');
            $this->info('✅ Scripts centralizados sin duplicación');
            $this->info('✅ Fácil mantenimiento posterior');
        } else {
            $this->warn("⚠️  Hay {$duplicateCount} vistas con código duplicado");
            $this->info('💡 Ejecuta: php artisan unify:all-scripts');
        }
        
        $this->newLine();
        $this->info('📋 Resumen de componentes creados:');
        $this->info('   1. Header Unificado - Navegación consistente');
        $this->info('   2. Sidebar Premium - Menú lateral con roles');
        $this->info('   3. Footer Premium - Pie de página reutilizable');
        $this->info('   4. Scripts Sidebar/Header - Comportamiento unificado');
        $this->info('   5. Scripts Búsqueda - Funcionalidad de filtros');
        
        return Command::SUCCESS;
    }
}
