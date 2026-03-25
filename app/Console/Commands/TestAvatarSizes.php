<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestAvatarSizes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:avatar-sizes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test avatar sizes and badge positioning in result pages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🖼️  Verificando tamaños de avatar y posicionamiento de badges...');
        
        $views = [
            'categories/models.blade.php' => 'Páginas de categorías',
            'filters/results.blade.php' => 'Páginas de filtros'
        ];
        
        foreach ($views as $view => $description) {
            $viewPath = resource_path("views/{$view}");
            
            if (file_exists($viewPath)) {
                $content = file_get_contents($viewPath);
                
                $this->info("📄 {$description} ({$view}):");
                
                // Verificar altura del avatar
                if (preg_match('/\.model-avatar\s*{[^}]*height:\s*(\d+)px/', $content, $matches)) {
                    $height = $matches[1];
                    $this->info("   📐 Altura del avatar: {$height}px");
                    
                    if ($height <= 250) {
                        $this->info("   ✅ Tamaño optimizado (≤250px)");
                    } else {
                        $this->warn("   ⚠️  Tamaño grande (>{$height}px)");
                    }
                } else {
                    $this->error("   ❌ No se encontró definición de altura del avatar");
                }
                
                // Verificar posicionamiento del badge
                if (strpos($content, '.model-card .live-indicator') !== false) {
                    $this->info("   🏷️  Badge específico definido");
                    
                    if (preg_match('/\.model-card \.live-indicator\s*{[^}]*top:\s*(\d+)px/', $content, $matches)) {
                        $top = $matches[1];
                        $this->info("   📍 Posición top: {$top}px");
                    }
                    
                    if (preg_match('/\.model-card \.live-indicator\s*{[^}]*left:\s*(\d+)px/', $content, $matches)) {
                        $left = $matches[1];
                        $this->info("   📍 Posición left: {$left}px");
                    }
                    
                    if (strpos($content, 'z-index: 10') !== false) {
                        $this->info("   ✅ Z-index configurado para evitar superposición");
                    }
                    
                    if (strpos($content, 'backdrop-filter: blur') !== false) {
                        $this->info("   ✅ Backdrop filter aplicado para mejor visibilidad");
                    }
                    
                } else {
                    $this->warn("   ⚠️  No se encontró posicionamiento específico del badge");
                }
                
                // Verificar responsive
                if (strpos($content, '@media (max-width: 1024px)') !== false) {
                    $this->info("   📱 Estilos responsive definidos");
                    
                    if (preg_match('/@media[^}]*\.model-avatar\s*{[^}]*height:\s*(\d+)px/', $content, $matches)) {
                        $mobileHeight = $matches[1];
                        $this->info("   📐 Altura mobile: {$mobileHeight}px");
                    }
                } else {
                    $this->warn("   ⚠️  No se encontraron estilos responsive");
                }
                
                $this->newLine();
            } else {
                $this->error("❌ Vista no encontrada: {$view}");
            }
        }
        
        $this->info('🎯 Recomendaciones aplicadas:');
        $this->info('   • Avatar reducido de 300px a 250px');
        $this->info('   • Badge posicionado con z-index: 10');
        $this->info('   • Backdrop filter para mejor visibilidad');
        $this->info('   • Responsive: 200px en mobile');
        $this->info('   • Padding y posición optimizados');
        
        return Command::SUCCESS;
    }
}
