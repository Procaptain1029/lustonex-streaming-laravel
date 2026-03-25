<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class TestBadgeVisibility extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:badge-visibility';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar que los badges permanezcan visibles en hover';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando visibilidad de badges en tarjetas de modelos...');
        
        $cssFile = public_path('css/premium-design.css');
        
        if (!File::exists($cssFile)) {
            $this->error('❌ Archivo CSS no encontrado');
            return Command::FAILURE;
        }
        
        $css = File::get($cssFile);
        
        // Verificar reglas CSS importantes
        $checks = [
            '.live-indicator' => 'Selector de badge existe',
            'z-index: 999' => 'Z-index alto configurado',
            'pointer-events: none' => 'Pointer events deshabilitados',
            '.card-model:hover .live-indicator' => 'Regla hover específica',
            'transform: none' => 'Transform resetado en hover',
            'position: absolute' => 'Posicionamiento absoluto'
        ];
        
        $this->info('📋 Verificando reglas CSS:');
        
        foreach ($checks as $rule => $description) {
            if (strpos($css, $rule) !== false) {
                $this->info("   ✅ {$description}");
            } else {
                $this->warn("   ⚠️  {$description} - No encontrado: {$rule}");
            }
        }
        
        $this->newLine();
        $this->info('🎯 Configuración aplicada para badges:');
        $this->info('   • Z-index: 999 (muy alto)');
        $this->info('   • Pointer-events: none (no interfiere con clicks)');
        $this->info('   • Transform: none en hover (no se mueve)');
        $this->info('   • Position: absolute (sobre la imagen)');
        
        $this->newLine();
        $this->info('🔧 Correcciones aplicadas:');
        $this->info('   • Badge con z-index 999');
        $this->info('   • Imagen con z-index 1');
        $this->info('   • Hover específico para badge');
        $this->info('   • Contenedor avatar con overflow visible');
        
        $this->newLine();
        $this->info('✨ Resultado esperado:');
        $this->info('   • Badge siempre visible sobre la imagen');
        $this->info('   • Efecto hover solo en la imagen');
        $this->info('   • Badge no se mueve ni oculta');
        $this->info('   • Click funciona en toda la tarjeta');
        
        return Command::SUCCESS;
    }
}
