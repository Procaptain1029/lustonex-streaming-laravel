<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CheckConflictingCSS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:conflicting-css';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar CSS conflictivo que pueda mover el header';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando CSS conflictivo en vistas de autenticación...');
        
        $authViews = [
            'auth/login.blade.php' => 'Inicio de sesión',
            'auth/register.blade.php' => 'Registro de fans',
            'auth/register-model.blade.php' => 'Registro de modelos'
        ];
        
        $conflictsFound = false;
        
        foreach ($authViews as $viewPath => $description) {
            $fullPath = resource_path("views/{$viewPath}");
            
            $this->info("📄 Verificando: {$description}");
            
            if (File::exists($fullPath)) {
                $content = File::get($fullPath);
                
                // Buscar CSS conflictivo
                $conflicts = [
                    '.header-content {' => 'Regla CSS para header-content',
                    'margin-left: 280px' => 'Margin-left que mueve el header',
                    '.sidebar-collapsed .header-content' => 'Regla CSS de sidebar colapsado para header',
                    'header.classList.toggle' => 'JavaScript que modifica el header'
                ];
                
                $hasConflicts = false;
                foreach ($conflicts as $pattern => $description) {
                    if (strpos($content, $pattern) !== false) {
                        $this->error("   ❌ {$description}: Encontrado");
                        $hasConflicts = true;
                        $conflictsFound = true;
                    }
                }
                
                if (!$hasConflicts) {
                    $this->info("   ✅ Sin CSS conflictivo");
                }
                
                // Verificar que tenga el padding correcto
                if (strpos($content, 'padding-top: 70px') !== false) {
                    $this->info("   ✅ Padding-top correcto presente");
                } else {
                    $this->warn("   ⚠️  Padding-top faltante");
                }
                
            } else {
                $this->error("   ❌ Vista no encontrada: {$viewPath}");
            }
            
            $this->newLine();
        }
        
        $this->info('🎯 Verificando CSS global:');
        
        $globalCSS = public_path('css/premium-design.css');
        if (File::exists($globalCSS)) {
            $content = File::get($globalCSS);
            
            // Verificar que el CSS global esté correcto
            if (strpos($content, 'position: fixed') !== false) {
                $this->info("   ✅ Header con position: fixed");
            } else {
                $this->warn("   ⚠️  Header sin position: fixed");
            }
            
            if (strpos($content, 'padding: 1rem 2rem') !== false) {
                $this->info("   ✅ Header con padding correcto");
            } else {
                $this->warn("   ⚠️  Header sin padding");
            }
            
        } else {
            $this->error("   ❌ CSS global no encontrado");
        }
        
        $this->newLine();
        if (!$conflictsFound) {
            $this->info('🎉 ¡No se encontró CSS conflictivo!');
            $this->info('✅ Header debe permanecer fijo en todas las vistas');
            $this->info('✅ CSS limpio sin reglas que muevan el header');
        } else {
            $this->warn('⚠️  Se encontró CSS conflictivo');
            $this->info('💡 Elimina las reglas CSS que modifican .header-content');
        }
        
        $this->newLine();
        $this->info('🔧 Reglas eliminadas:');
        $this->info('   • .header-content { margin-left: 280px; }');
        $this->info('   • .sidebar-collapsed .header-content { margin-left: 0; }');
        $this->info('   • @media .header-content { margin-left: 0; }');
        
        return Command::SUCCESS;
    }
}
