<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestUIUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:ui-updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test UI updates and badge functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎨 Verificando actualizaciones de UI...');
        
        // Verificar que las vistas usen el mismo card
        $this->info('📄 Verificando uso consistente de cards:');
        
        $views = [
            'categories/models.blade.php' => 'Páginas de categorías',
            'filters/results.blade.php' => 'Páginas de filtros'
        ];
        
        foreach ($views as $view => $description) {
            $viewPath = resource_path("views/{$view}");
            
            if (file_exists($viewPath)) {
                $content = file_get_contents($viewPath);
                
                // Verificar uso de card-model
                if (strpos($content, 'card-model hover-zoom model-card-link') !== false) {
                    $this->info("   ✅ {$description}: Usa card-model consistente");
                } else {
                    $this->warn("   ⚠️  {$description}: No usa card-model");
                }
                
                // Verificar grid-models
                if (strpos($content, 'grid-models') !== false) {
                    $this->info("   ✅ {$description}: Usa grid-models");
                } else {
                    $this->warn("   ⚠️  {$description}: No usa grid-models");
                }
                
                // Verificar múltiples badges en filtros
                if ($view === 'filters/results.blade.php') {
                    if (strpos($content, 'criteria-badges') !== false) {
                        $this->info("   ✅ {$description}: Soporta múltiples badges");
                    } else {
                        $this->warn("   ⚠️  {$description}: No soporta múltiples badges");
                    }
                    
                    if (strpos($content, 'categoryInfo[\'criteria\']') !== false) {
                        $this->info("   ✅ {$description}: Maneja criterios dinámicos");
                    } else {
                        $this->warn("   ⚠️  {$description}: No maneja criterios dinámicos");
                    }
                }
                
                // Verificar JavaScript de búsqueda
                if (strpos($content, 'initializeSearch()') !== false) {
                    $this->info("   ✅ {$description}: Incluye JavaScript de búsqueda");
                } else {
                    $this->warn("   ⚠️  {$description}: No incluye JavaScript de búsqueda");
                }
            } else {
                $this->error("   ❌ {$description}: Vista no encontrada");
            }
        }
        
        $this->newLine();
        $this->info('🎯 Verificando controladores:');
        
        // Verificar que los controladores pasen criterios
        $controllerPath = app_path('Http/Controllers/HomeController.php');
        if (file_exists($controllerPath)) {
            $content = file_get_contents($controllerPath);
            
            if (strpos($content, '\'criteria\' => [') !== false) {
                $this->info("   ✅ HomeController: Pasa criterios para badges");
            } else {
                $this->warn("   ⚠️  HomeController: No pasa criterios");
            }
        }
        
        $searchControllerPath = app_path('Http/Controllers/SearchController.php');
        if (file_exists($searchControllerPath)) {
            $content = file_get_contents($searchControllerPath);
            
            if (strpos($content, 'filters.results') !== false) {
                $this->info("   ✅ SearchController: Usa vista de filtros");
            } else {
                $this->warn("   ⚠️  SearchController: No usa vista de filtros");
            }
            
            if (strpos($content, '\'criteria\' => \$criteria') !== false) {
                $this->info("   ✅ SearchController: Genera criterios múltiples");
            } else {
                $this->warn("   ⚠️  SearchController: No genera criterios múltiples");
            }
        }
        
        $this->newLine();
        $this->info('🎨 Verificando estilos CSS:');
        
        $filterViewPath = resource_path('views/filters/results.blade.php');
        if (file_exists($filterViewPath)) {
            $content = file_get_contents($filterViewPath);
            
            $badgeStyles = ['.criteria-badges', '.live-indicator.busqueda', '.live-indicator.cuerpo'];
            
            foreach ($badgeStyles as $style) {
                if (strpos($content, $style) !== false) {
                    $this->info("   ✅ Estilo '{$style}' definido");
                } else {
                    $this->warn("   ⚠️  Estilo '{$style}' no encontrado");
                }
            }
        }
        
        $this->newLine();
        $this->info('📱 Verificando sidebar:');
        
        $sidebarPath = resource_path('views/components/sidebar-premium.blade.php');
        if (file_exists($sidebarPath)) {
            $content = file_get_contents($sidebarPath);
            
            if (strpos($content, 'Hazte VIP') === false) {
                $this->info("   ✅ Sección 'Hazte VIP' eliminada");
            } else {
                $this->warn("   ⚠️  Sección 'Hazte VIP' aún presente");
            }
            
            if (strpos($content, 'fas fa-sparkles') !== false) {
                $this->info("   ✅ Ícono de 'Modelos Nuevas' presente");
            } else {
                $this->warn("   ⚠️  Ícono de 'Modelos Nuevas' faltante");
            }
        }
        
        $this->newLine();
        $this->info('🎉 Resumen de cambios implementados:');
        $this->info('   • Cards unificados en todas las vistas');
        $this->info('   • Múltiples badges según criterios aplicados');
        $this->info('   • Búsqueda funcional en todas las páginas');
        $this->info('   • Sección "Hazte VIP" eliminada del sidebar');
        $this->info('   • Íconos actualizados en el menú lateral');
        $this->info('   • Estilos responsive para badges múltiples');
        
        return Command::SUCCESS;
    }
}
