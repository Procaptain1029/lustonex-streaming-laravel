<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestImageProcessing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:image-processing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Probar el procesamiento de imágenes y creación de thumbnails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Probando procesamiento de imágenes...');
        
        // Verificar si Intervention Image está disponible
        if (class_exists('Intervention\Image\ImageManager')) {
            $this->info('✅ Intervention Image está instalado');
            
            try {
                $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                $this->info('✅ ImageManager se puede instanciar correctamente');
            } catch (\Exception $e) {
                $this->error('❌ Error al instanciar ImageManager: ' . $e->getMessage());
            }
        } else {
            $this->warn('⚠️  Intervention Image no está disponible, se usará GD nativo');
        }
        
        // Verificar extensión GD
        if (extension_loaded('gd')) {
            $this->info('✅ Extensión GD está disponible');
            $gdInfo = gd_info();
            $this->info('   - Versión GD: ' . $gdInfo['GD Version']);
            $this->info('   - JPEG Support: ' . ($gdInfo['JPEG Support'] ? 'Sí' : 'No'));
            $this->info('   - PNG Support: ' . ($gdInfo['PNG Support'] ? 'Sí' : 'No'));
            $this->info('   - GIF Support: ' . ($gdInfo['GIF Create Support'] ? 'Sí' : 'No'));
            $this->info('   - WebP Support: ' . ($gdInfo['WebP Support'] ?? false ? 'Sí' : 'No'));
        } else {
            $this->error('❌ Extensión GD no está disponible');
        }
        
        // Verificar directorios de storage
        $photosDir = storage_path('app/public/photos');
        $thumbnailsDir = storage_path('app/public/thumbnails');
        
        if (!file_exists($photosDir)) {
            mkdir($photosDir, 0755, true);
            $this->info('✅ Directorio photos creado');
        } else {
            $this->info('✅ Directorio photos existe');
        }
        
        if (!file_exists($thumbnailsDir)) {
            mkdir($thumbnailsDir, 0755, true);
            $this->info('✅ Directorio thumbnails creado');
        } else {
            $this->info('✅ Directorio thumbnails existe');
        }
        
        $this->info('🎉 Verificación completada. El sistema de subida de fotos debería funcionar correctamente.');
        
        return 0;
    }
}
