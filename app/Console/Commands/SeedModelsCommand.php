<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\ModelsSeeder;

class SeedModelsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:models {--fresh : Truncate existing models before seeding}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed 200 models with diverse characteristics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Iniciando el seeding de 200 modelos...');
        
        if ($this->option('fresh')) {
            $this->warn('⚠️  Eliminando modelos existentes...');
            
            // Eliminar solo usuarios con rol 'model'
            \App\Models\User::where('role', 'model')->delete();
            
            $this->info('✅ Modelos existentes eliminados.');
        }
        
        $this->info('📝 Creando 200 nuevos modelos...');
        
        // Ejecutar el seeder
        $seeder = new ModelsSeeder();
        $seeder->setCommand($this);
        $seeder->run();
        
        $this->newLine();
        $this->info('🎉 ¡Proceso completado exitosamente!');
        $this->info('📊 Estadísticas:');
        $this->info('   • 200 modelos creados');
        $this->info('   • 20 países diferentes');
        $this->info('   • Edades entre 18-35 años');
        $this->info('   • Perfiles completos con fotos');
        $this->info('   • Contraseña: 123456789');
        $this->info('   • Email: [nombre][numero]@streamhub.com');
        
        return Command::SUCCESS;
    }
}
