<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckComponents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:components';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if all required components exist';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando componentes requeridos...');
        
        $components = [
            'header-premium' => 'Header premium para páginas con sidebar',
            'sidebar-premium' => 'Sidebar premium con filtros',
            'search-models' => 'Componente de búsqueda de modelos',
            'footer-premium' => 'Footer premium'
        ];
        
        $allExist = true;
        
        foreach ($components as $component => $description) {
            $path = resource_path("views/components/{$component}.blade.php");
            
            if (file_exists($path)) {
                $this->info("✅ {$component}.blade.php - {$description}");
            } else {
                $this->error("❌ {$component}.blade.php - FALTA: {$description}");
                $allExist = false;
            }
        }
        
        $this->newLine();
        
        // Verificar vistas que usan los componentes
        $this->info('📄 Verificando vistas que usan componentes...');
        
        $views = [
            'categories/models.blade.php' => ['header-premium', 'sidebar-premium'],
            'filters/results.blade.php' => ['header-premium', 'sidebar-premium'],
            'welcome.blade.php' => ['sidebar-premium', 'search-models']
        ];
        
        foreach ($views as $view => $requiredComponents) {
            $viewPath = resource_path("views/{$view}");
            
            if (file_exists($viewPath)) {
                $this->info("✅ {$view} existe");
                
                $content = file_get_contents($viewPath);
                
                foreach ($requiredComponents as $component) {
                    if (strpos($content, "@include('components.{$component}')") !== false) {
                        $this->info("   ✅ Incluye {$component}");
                    } else {
                        $this->warn("   ⚠️  No incluye {$component}");
                    }
                }
            } else {
                $this->error("❌ {$view} - NO EXISTE");
                $allExist = false;
            }
        }
        
        $this->newLine();
        
        if ($allExist) {
            $this->info('🎉 Todos los componentes están disponibles!');
        } else {
            $this->error('❌ Faltan algunos componentes. Revisa los errores arriba.');
        }
        
        return $allExist ? Command::SUCCESS : Command::FAILURE;
    }
}
