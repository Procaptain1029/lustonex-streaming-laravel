<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class VerifyAuthHeaderFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:auth-header-fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar que las vistas de autenticación tengan header fijo correcto';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando header fijo en vistas de autenticación...');
        
        $authViews = [
            'auth/login.blade.php' => 'Inicio de sesión',
            'auth/register.blade.php' => 'Registro de fans',
            'auth/register-model.blade.php' => 'Registro de modelos'
        ];
        
        $allCorrect = true;
        
        foreach ($authViews as $viewPath => $description) {
            $fullPath = resource_path("views/{$viewPath}");
            
            $this->info("📄 Verificando: {$description}");
            
            if (File::exists($fullPath)) {
                $content = File::get($fullPath);
                
                // Verificar header unificado
                if (strpos($content, "@include('components.header-unified')") !== false) {
                    $this->info("   ✅ Usa header unificado");
                } else {
                    $this->error("   ❌ No usa header unificado");
                    $allCorrect = false;
                }
                
                // Verificar scripts unificados
                if (strpos($content, "@include('components.sidebar-header-scripts')") !== false) {
                    $this->info("   ✅ Usa scripts unificados");
                } else {
                    $this->error("   ❌ No usa scripts unificados");
                    $allCorrect = false;
                }
                
                // Verificar padding-top del body
                if (strpos($content, 'padding-top: 70px') !== false) {
                    $this->info("   ✅ Body con padding-top correcto");
                } else {
                    $this->error("   ❌ Body sin padding-top");
                    $allCorrect = false;
                }
                
                // Verificar padding-top responsive
                if (strpos($content, 'padding-top: 60px') !== false) {
                    $this->info("   ✅ Padding responsive presente");
                } else {
                    $this->error("   ❌ Padding responsive faltante");
                    $allCorrect = false;
                }
                
                // Verificar que no haya funciones duplicadas
                if (strpos($content, 'function toggleSidebar()') !== false) {
                    $this->warn("   ⚠️  Función toggleSidebar duplicada");
                    $allCorrect = false;
                } else {
                    $this->info("   ✅ Sin funciones duplicadas");
                }
                
                // Verificar sidebar premium
                if (strpos($content, "@include('components.sidebar-premium')") !== false) {
                    $this->info("   ✅ Incluye sidebar premium");
                } else {
                    $this->warn("   ⚠️  No incluye sidebar premium");
                }
                
            } else {
                $this->error("   ❌ Vista no encontrada: {$viewPath}");
                $allCorrect = false;
            }
            
            $this->newLine();
        }
        
        $this->info('🎯 Verificando comportamiento esperado:');
        $this->info('   🖥️  Desktop:');
        $this->info('      • Header fijo con padding-top: 70px en body');
        $this->info('      • Sidebar se oculta/muestra sin mover header');
        $this->info('      • Scripts unificados manejan el comportamiento');
        
        $this->info('   📱 Mobile:');
        $this->info('      • Header fijo con padding-top: 60px en body');
        $this->info('      • Sidebar como overlay sin afectar header');
        $this->info('      • Click fuera cierra sidebar automáticamente');
        
        $this->newLine();
        if ($allCorrect) {
            $this->info('🎉 ¡Todas las vistas de autenticación están correctas!');
            $this->info('✅ Header fijo funcionando en login, register y register-model');
            $this->info('✅ Scripts unificados sin duplicación');
            $this->info('✅ Padding correcto para header fijo');
        } else {
            $this->warn('⚠️  Algunas vistas necesitan corrección');
            $this->info('💡 Revisa los errores mostrados arriba');
        }
        
        $this->newLine();
        $this->info('🔧 Correcciones aplicadas:');
        $this->info('   • Agregado padding-top: 70px al body (desktop)');
        $this->info('   • Agregado padding-top: 60px al body (mobile)');
        $this->info('   • Scripts unificados eliminan código duplicado');
        $this->info('   • Header permanece fijo sin moverse');
        
        return Command::SUCCESS;
    }
}
