<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class TestCategoryRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:category-routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test category routes and their functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Probando rutas de categorías...');
        
        $routes = [
            'modelos.nuevas' => '/modelos/nuevas',
            'modelos.nivel-alto' => '/modelos/nivel-alto',
            'modelos.vip-popular' => '/modelos/vip-popular',
            'modelos.favoritas' => '/modelos/favoritas'
        ];
        
        foreach ($routes as $name => $uri) {
            try {
                $route = Route::getRoutes()->getByName($name);
                if ($route) {
                    $this->info("✅ Ruta '{$name}' -> {$uri} - Registrada correctamente");
                } else {
                    $this->error("❌ Ruta '{$name}' no encontrada");
                }
            } catch (\Exception $e) {
                $this->error("❌ Error en ruta '{$name}': " . $e->getMessage());
            }
        }
        
        $this->newLine();
        $this->info('🎯 Probando controladores...');
        
        $controller = app(\App\Http\Controllers\HomeController::class);
        
        $methods = ['nuevasModelos', 'nivelAltoModelos', 'vipPopularModelos', 'favoritasModelos'];
        
        foreach ($methods as $method) {
            if (method_exists($controller, $method)) {
                $this->info("✅ Método '{$method}' existe en HomeController");
            } else {
                $this->error("❌ Método '{$method}' no encontrado en HomeController");
            }
        }
        
        $this->newLine();
        $this->info('📁 Verificando vista de categorías...');
        
        $viewPath = resource_path('views/categories/models.blade.php');
        if (file_exists($viewPath)) {
            $this->info("✅ Vista 'categories.models' existe");
        } else {
            $this->error("❌ Vista 'categories.models' no encontrada");
        }
        
        $this->newLine();
        $this->info('🎨 Verificando estilos CSS...');
        
        $cssPath = public_path('css/premium-design.css');
        if (file_exists($cssPath)) {
            $cssContent = file_get_contents($cssPath);
            
            $styles = ['.live-indicator.nueva', '.live-indicator.premium', '.live-indicator.vip', '.live-indicator.favorita'];
            
            foreach ($styles as $style) {
                if (strpos($cssContent, $style) !== false) {
                    $this->info("✅ Estilo '{$style}' encontrado");
                } else {
                    $this->error("❌ Estilo '{$style}' no encontrado");
                }
            }
        } else {
            $this->error("❌ Archivo CSS premium-design.css no encontrado");
        }
        
        $this->newLine();
        $this->info('🎉 Verificación completada!');
        
        return Command::SUCCESS;
    }
}
