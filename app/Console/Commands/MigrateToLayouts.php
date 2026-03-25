<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MigrateToLayouts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:layouts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrar todas las vistas para usar layouts centralizados';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Migrando vistas a layouts centralizados...');

        // Vistas de autenticación que usarán layout auth
        $authViews = [
            'auth/login.blade.php' => 'Inicio de sesión',
            'auth/register.blade.php' => 'Registro de fans',
            'auth/register-model.blade.php' => 'Registro de modelos'
        ];

        // Vistas principales que usarán layout premium
        $premiumViews = [
            'profiles/show.blade.php' => 'Perfil de modelo',
            'search/results.blade.php' => 'Resultados de búsqueda',
            'categories/models.blade.php' => 'Categorías de modelos',
            'filters/results.blade.php' => 'Resultados de filtros',
            'fan/dashboard.blade.php' => 'Dashboard de fan',
            'fan/tokens/index.blade.php' => 'Tokens del fan',
            'fan/subscriptions/index.blade.php' => 'Suscripciones',
            'model/dashboard.blade.php' => 'Dashboard de modelo',
            'model/profile/edit.blade.php' => 'Editar perfil'
        ];

        $migratedCount = 0;

        // Migrar vistas de autenticación
        $this->info('📄 Migrando vistas de autenticación...');
        foreach ($authViews as $viewPath => $description) {
            if ($this->migrateAuthView($viewPath, $description)) {
                $migratedCount++;
            }
        }

        // Migrar vistas premium
        $this->info('📄 Migrando vistas premium...');
        foreach ($premiumViews as $viewPath => $description) {
            if ($this->migratePremiumView($viewPath, $description)) {
                $migratedCount++;
            }
        }

        $this->newLine();
        $this->info('📊 Resumen de migración:');
        $this->info("   • Vistas migradas: {$migratedCount}");
        $this->info("   • Layout auth: " . count($authViews));
        $this->info("   • Layout premium: " . count($premiumViews));

        $this->newLine();
        $this->info('🎯 Beneficios de los layouts centralizados:');
        $this->info('   • CSS y scripts centralizados');
        $this->info('   • Fácil mantenimiento');
        $this->info('   • Consistencia visual garantizada');
        $this->info('   • Componentes reutilizables');
        $this->info('   • Actualizaciones globales simples');

        return Command::SUCCESS;
    }

    private function migrateAuthView($viewPath, $description)
    {
        $fullPath = resource_path("views/{$viewPath}");

        if (!File::exists($fullPath)) {
            $this->warn("   ⚠️  Vista no encontrada: {$viewPath}");
            return false;
        }

        $content = File::get($fullPath);

        // Verificar si ya usa layout
        if (strpos($content, '@extends(') !== false) {
            $this->comment("   ℹ️  {$description}: Ya usa layout");
            return false;
        }

        // Extraer el contenido principal (entre <body> y </body>)
        preg_match('/<body[^>]*>(.*?)<\/body>/s', $content, $matches);
        if (!$matches) {
            $this->warn("   ⚠️  {$description}: No se pudo extraer contenido");
            return false;
        }

        $bodyContent = $matches[1];

        // Limpiar el contenido (remover header, sidebar, scripts)
        $bodyContent = preg_replace('/@include\([\'"]components\.header-unified[\'"]\)/', '', $bodyContent);
        $bodyContent = preg_replace('/@include\([\'"]components\.sidebar-premium[\'"]\)/', '', $bodyContent);
        $bodyContent = preg_replace('/@include\([\'"]components\.sidebar-header-scripts[\'"]\)/', '', $bodyContent);
        $bodyContent = preg_replace('/@include\([\'"]components\.search-scripts[\'"]\)/', '', $bodyContent);

        // Extraer el contenido del main-content
        preg_match('/<div class="main-content"[^>]*>(.*?)<\/div>/s', $bodyContent, $mainMatches);
        if ($mainMatches) {
            $bodyContent = $mainMatches[1];
        }

        // Extraer título de la página
        preg_match('/<title>(.*?)<\/title>/', $content, $titleMatches);
        $title = $titleMatches ? trim(str_replace(' - Lustonex', '', $titleMatches[1])) : $description;

        // Crear nuevo contenido con layout
        $newContent = "@extends('layouts.auth')\n\n";
        $newContent .= "@section('title', '{$title}')\n\n";
        $newContent .= "@section('content')\n";
        $newContent .= trim($bodyContent) . "\n";
        $newContent .= "@endsection\n";

        File::put($fullPath, $newContent);
        $this->info("   ✅ {$description}: Migrado a layout auth");
        return true;
    }

    private function migratePremiumView($viewPath, $description)
    {
        $fullPath = resource_path("views/{$viewPath}");

        if (!File::exists($fullPath)) {
            $this->warn("   ⚠️  Vista no encontrada: {$viewPath}");
            return false;
        }

        $content = File::get($fullPath);

        // Verificar si ya usa layout
        if (strpos($content, '@extends(') !== false) {
            $this->comment("   ℹ️  {$description}: Ya usa layout");
            return false;
        }

        // Para vistas que ya usan componentes, simplificar
        if (strpos($content, "@include('components.header-unified')") !== false) {
            // Extraer solo el contenido principal
            preg_match('/<div class="main-content"[^>]*>(.*?)<\/div>/s', $content, $matches);
            if ($matches) {
                $mainContent = trim($matches[1]);

                $newContent = "@extends('layouts.premium')\n\n";
                $newContent .= "@section('title', '{$description}')\n\n";
                $newContent .= "@section('content')\n";
                $newContent .= $mainContent . "\n";
                $newContent .= "@endsection\n";

                File::put($fullPath, $newContent);
                $this->info("   ✅ {$description}: Migrado a layout premium");
                return true;
            }
        }

        $this->warn("   ⚠️  {$description}: Requiere migración manual");
        return false;
    }
}
