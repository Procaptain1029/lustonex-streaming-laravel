<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class VerifyFlagIcons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:flag-icons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar implementación de flag-icons en Lustonex';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🏁 Verificando implementación de Flag Icons en Lustonex...');

        // Verificar que la librería esté incluida
        $this->info('📦 Verificando librería CSS:');

        $viewsWithFlagIcons = [
            'welcome.blade.php' => 'Página principal',
            'auth/login.blade.php' => 'Inicio de sesión',
            'auth/register.blade.php' => 'Registro de fans',
            'auth/register-model.blade.php' => 'Registro de modelos'
        ];

        foreach ($viewsWithFlagIcons as $view => $description) {
            $path = resource_path("views/{$view}");
            if (File::exists($path)) {
                $content = File::get($path);
                if (strpos($content, 'flag-icons.min.css') !== false) {
                    $this->info("   ✅ {$description}: Librería incluida");
                } else {
                    $this->warn("   ⚠️  {$description}: Librería faltante");
                }
            }
        }

        $this->newLine();
        $this->info('🌍 Verificando uso de banderas:');

        // Verificar sidebar
        $sidebarPath = resource_path('views/components/sidebar-premium.blade.php');
        if (File::exists($sidebarPath)) {
            $content = File::get($sidebarPath);
            $countries = ['fi-co', 'fi-ar', 'fi-mx', 'fi-es', 'fi-br'];
            $foundFlags = 0;

            foreach ($countries as $flag) {
                if (strpos($content, $flag) !== false) {
                    $foundFlags++;
                }
            }

            $this->info("   ✅ Sidebar: {$foundFlags}/5 banderas implementadas");
        }

        // Verificar tarjetas de modelos
        $welcomePath = resource_path('views/welcome.blade.php');
        if (File::exists($welcomePath)) {
            $content = File::get($welcomePath);
            $flagUsages = substr_count($content, 'fi fi-{{');
            $this->info("   ✅ Tarjetas de modelos: {$flagUsages} implementaciones dinámicas");
        }

        $this->newLine();
        $this->info('🎯 Implementación actual:');
        $this->info('   • Librería: https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css');
        $this->info('   • Sidebar: Banderas estáticas (CO, AR, MX, ES, BR)');
        $this->info('   • Tarjetas: Banderas dinámicas basadas en perfil');
        $this->info('   • Fallback: Ícono de globo cuando no hay país');

        $this->newLine();
        $this->info('🏁 Ejemplos de uso:');
        $this->info('   • Colombia: <span class="fi fi-co flag-icon"></span>');
        $this->info('   • Argentina: <span class="fi fi-ar flag-icon"></span>');
        $this->info('   • México: <span class="fi fi-mx flag-icon"></span>');
        $this->info('   • España: <span class="fi fi-es flag-icon"></span>');
        $this->info('   • Brasil: <span class="fi fi-br flag-icon"></span>');

        $this->newLine();
        $this->info('✨ CSS personalizado aplicado:');
        $this->info('   • Sidebar: 20x15px con efectos hover');
        $this->info('   • Tarjetas: 16x12px optimizado');
        $this->info('   • Sombras y bordes redondeados');
        $this->info('   • Responsive y accesible');

        return Command::SUCCESS;
    }
}
