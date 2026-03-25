<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestHeaderPadding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:header-padding';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar que el header tenga padding correcto top y bottom';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎨 Verificando padding del header...');
        
        $cssPath = public_path('css/premium-design.css');
        if (file_exists($cssPath)) {
            $content = file_get_contents($cssPath);
            
            $this->info('📄 Verificando estilos del header:');
            
            // Verificar padding del header-content
            if (strpos($content, 'padding: 1rem 2rem') !== false) {
                $this->info('   ✅ Header-content tiene padding vertical (1rem top/bottom)');
            } else {
                $this->warn('   ⚠️  Header-content sin padding vertical');
            }
            
            // Verificar min-height
            if (strpos($content, 'min-height: 70px') !== false) {
                $this->info('   ✅ Header-content tiene altura mínima (70px)');
            } else {
                $this->warn('   ⚠️  Header-content sin altura mínima');
            }
            
            // Verificar padding-top del body
            if (strpos($content, 'padding-top: 70px') !== false) {
                $this->info('   ✅ Body tiene padding-top para compensar header fijo');
            } else {
                $this->warn('   ⚠️  Body sin padding-top');
            }
            
            $this->newLine();
            $this->info('📱 Verificando estilos responsive:');
            
            // Verificar padding responsive
            if (strpos($content, 'padding: 0.75rem 1rem') !== false) {
                $this->info('   ✅ Header responsive con padding reducido');
            } else {
                $this->warn('   ⚠️  Header responsive sin padding');
            }
            
            // Verificar min-height responsive
            if (strpos($content, 'min-height: 60px') !== false) {
                $this->info('   ✅ Header responsive con altura mínima (60px)');
            } else {
                $this->warn('   ⚠️  Header responsive sin altura mínima');
            }
            
            // Verificar body responsive
            $responsiveSection = substr($content, strpos($content, '@media (max-width: 1024px)'));
            if (strpos($responsiveSection, 'body {') !== false && 
                strpos($responsiveSection, 'padding-top: 60px') !== false) {
                $this->info('   ✅ Body responsive con padding-top reducido');
            } else {
                $this->warn('   ⚠️  Body responsive sin padding-top');
            }
            
        } else {
            $this->error('   ❌ Archivo CSS no encontrado');
        }
        
        $this->newLine();
        $this->info('🎯 Especificaciones del header:');
        
        $this->info('   🖥️  Desktop:');
        $this->info('      • Padding: 1rem top/bottom, 2rem left/right');
        $this->info('      • Min-height: 70px');
        $this->info('      • Body padding-top: 70px');
        
        $this->info('   📱 Mobile:');
        $this->info('      • Padding: 0.75rem top/bottom, 1rem left/right');
        $this->info('      • Min-height: 60px');
        $this->info('      • Body padding-top: 60px');
        
        $this->newLine();
        $this->info('✅ Beneficios del padding correcto:');
        $this->info('   • Header con altura adecuada y espaciado interno');
        $this->info('   • Elementos del header bien centrados verticalmente');
        $this->info('   • Contenido no oculto detrás del header fijo');
        $this->info('   • Diseño responsive optimizado para mobile');
        
        return Command::SUCCESS;
    }
}
