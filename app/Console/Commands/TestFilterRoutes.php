<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class TestFilterRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:filter-routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test filter routes and their results';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Probando rutas de filtros...');
        
        // Test filtros por país
        $this->info('🌍 Filtros por País:');
        $paises = ['colombia', 'argentina', 'mexico', 'espana', 'brasil'];
        foreach ($paises as $pais) {
            $count = $this->testFiltroPais($pais);
            $this->info("   🇨🇴 {$pais}: {$count} modelos");
        }
        
        $this->newLine();
        
        // Test filtros por edad
        $this->info('🎂 Filtros por Edad:');
        $edades = ['18-25', '26-30', '31-35', '36-plus'];
        foreach ($edades as $edad) {
            $count = $this->testFiltroEdad($edad);
            $this->info("   🌸 {$edad}: {$count} modelos");
        }
        
        $this->newLine();
        
        // Test filtros por etnia
        $this->info('🎨 Filtros por Etnia:');
        $etnias = ['latina', 'blanca', 'asiatica', 'negra', 'multietnica'];
        foreach ($etnias as $etnia) {
            $count = $this->testFiltroEtnia($etnia);
            $this->info("   🌹 {$etnia}: {$count} modelos");
        }
        
        $this->newLine();
        
        // Test filtros por cabello
        $this->info('💇‍♀️ Filtros por Cabello:');
        $cabellos = ['rubio', 'moreno', 'negro', 'pelirroja', 'colorido'];
        foreach ($cabellos as $cabello) {
            $count = $this->testFiltroCabello($cabello);
            $this->info("   👱‍♀️ {$cabello}: {$count} modelos");
        }
        
        $this->newLine();
        $this->info('✅ Pruebas de filtros completadas!');
        
        return Command::SUCCESS;
    }
    
    private function testFiltroPais($pais)
    {
        $paisesMap = [
            'colombia' => 'Colombia',
            'argentina' => 'Argentina', 
            'mexico' => 'México',
            'espana' => 'España',
            'brasil' => 'Brasil'
        ];

        $paisNombre = $paisesMap[$pais] ?? ucfirst($pais);

        return User::where('role', 'model')
            ->whereHas('profile', function($query) use ($paisNombre) {
                $query->where('profile_completed', true)
                      ->where('country', $paisNombre);
            })
            ->count();
    }
    
    private function testFiltroEdad($rango)
    {
        $rangosMap = [
            '18-25' => ['min' => 18, 'max' => 25],
            '26-30' => ['min' => 26, 'max' => 30],
            '31-35' => ['min' => 31, 'max' => 35],
            '36-plus' => ['min' => 36, 'max' => 99]
        ];

        $rangoData = $rangosMap[$rango] ?? $rangosMap['18-25'];

        return User::where('role', 'model')
            ->whereHas('profile', function($query) use ($rangoData) {
                $query->where('profile_completed', true)
                      ->whereBetween('age', [$rangoData['min'], $rangoData['max']]);
            })
            ->count();
    }
    
    private function testFiltroEtnia($etnia)
    {
        $etniasMap = [
            'latina' => 'Latina',
            'blanca' => 'Blanca',
            'asiatica' => 'Asiática',
            'negra' => 'Negra',
            'multietnica' => 'Multiétnica'
        ];

        $etniaNombre = $etniasMap[$etnia] ?? ucfirst($etnia);

        return User::where('role', 'model')
            ->whereHas('profile', function($query) use ($etniaNombre) {
                $query->where('profile_completed', true)
                      ->where('ethnicity', $etniaNombre);
            })
            ->count();
    }
    
    private function testFiltroCabello($tipo)
    {
        $cabellosMap = [
            'rubio' => 'Rubio',
            'moreno' => 'Moreno',
            'negro' => 'Pelo Negro',
            'pelirroja' => 'Pelirroja',
            'colorido' => 'Colorido'
        ];

        $cabelloNombre = $cabellosMap[$tipo] ?? ucfirst($tipo);

        return User::where('role', 'model')
            ->whereHas('profile', function($query) use ($cabelloNombre) {
                $query->where('profile_completed', true)
                      ->where('hair_color', $cabelloNombre);
            })
            ->count();
    }
}
