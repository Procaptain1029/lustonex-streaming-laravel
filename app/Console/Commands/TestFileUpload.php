<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TestFileUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:file-upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test file upload configuration and permissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing file upload configuration...');

        // Test 1: Check if storage directories exist
        $this->info('1. Checking storage directories...');
        
        $storagePath = storage_path('app/public');
        $documentsPath = storage_path('app/public/documents');
        $avatarsPath = storage_path('app/public/avatars');
        $coversPath = storage_path('app/public/covers');

        $this->checkDirectory($storagePath, 'storage/app/public');
        $this->checkDirectory($documentsPath, 'storage/app/public/documents');
        $this->checkDirectory($avatarsPath, 'storage/app/public/avatars');
        $this->checkDirectory($coversPath, 'storage/app/public/covers');

        // Test 2: Check if public/storage symlink exists
        $this->info('2. Checking public/storage symlink...');
        $publicStoragePath = public_path('storage');
        if (is_link($publicStoragePath)) {
            $this->info("✅ Symlink exists: {$publicStoragePath}");
            $target = readlink($publicStoragePath);
            $this->info("   Points to: {$target}");
        } else {
            $this->error("❌ Symlink missing: {$publicStoragePath}");
            $this->info("   Run: php artisan storage:link");
        }

        // Test 3: Test write permissions
        $this->info('3. Testing write permissions...');
        try {
            $testContent = 'Test file for upload verification - ' . now();
            $testPath = Storage::disk('public')->put('test-upload.txt', $testContent);
            
            if ($testPath) {
                $this->info("✅ File write successful: {$testPath}");
                
                // Test read
                $readContent = Storage::disk('public')->get($testPath);
                if ($readContent === $testContent) {
                    $this->info("✅ File read successful");
                } else {
                    $this->error("❌ File read failed");
                }
                
                // Clean up
                Storage::disk('public')->delete($testPath);
                $this->info("✅ Test file cleaned up");
            } else {
                $this->error("❌ File write failed");
            }
        } catch (\Exception $e) {
            $this->error("❌ Exception during file test: " . $e->getMessage());
        }

        // Test 4: Check disk configuration
        $this->info('4. Checking disk configuration...');
        $diskConfig = config('filesystems.disks.public');
        $this->info("   Driver: " . $diskConfig['driver']);
        $this->info("   Root: " . $diskConfig['root']);
        $this->info("   URL: " . $diskConfig['url']);

        // Test 5: Check PHP upload limits
        $this->info('5. Checking PHP upload limits...');
        $this->info("   upload_max_filesize: " . ini_get('upload_max_filesize'));
        $this->info("   post_max_size: " . ini_get('post_max_size'));
        $this->info("   max_file_uploads: " . ini_get('max_file_uploads'));
        $this->info("   memory_limit: " . ini_get('memory_limit'));

        $this->info('File upload test completed!');
    }

    private function checkDirectory($path, $name)
    {
        if (is_dir($path)) {
            $this->info("✅ Directory exists: {$name}");
            if (is_writable($path)) {
                $this->info("   ✅ Writable");
            } else {
                $this->error("   ❌ Not writable");
            }
        } else {
            $this->error("❌ Directory missing: {$name}");
            $this->info("   Creating directory...");
            if (mkdir($path, 0755, true)) {
                $this->info("   ✅ Directory created");
            } else {
                $this->error("   ❌ Failed to create directory");
            }
        }
    }
}
