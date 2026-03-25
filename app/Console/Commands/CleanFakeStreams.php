<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Stream;
use Illuminate\Support\Facades\Log;

class CleanFakeStreams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'streams:clean-fake';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar streams marcados como live pero sin transmisión real';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧹 Limpiando streams falsos...');
        
        // Buscar streams marcados como 'live'
        $liveStreams = Stream::where('status', 'live')->get();
        
        if ($liveStreams->count() === 0) {
            $this->info('✅ No hay streams marcados como live');
            return;
        }
        
        $cleaned = 0;
        
        foreach ($liveStreams as $stream) {
            $hlsDir = public_path("hls/webcam/{$stream->id}");
            $playlistFile = "{$hlsDir}/playlist.m3u8";
            
            // Si no existe el directorio HLS o el playlist, es un stream falso
            if (!file_exists($hlsDir) || !file_exists($playlistFile)) {
                $this->warn("❌ Stream {$stream->id} marcado como live pero sin archivos HLS");
                
                // Marcar como ended
                $stream->update([
                    'status' => 'ended',
                    'ended_at' => now()
                ]);
                
                // Actualizar perfil del modelo
                if ($stream->user && $stream->user->profile) {
                    $stream->user->profile->update(['is_streaming' => false]);
                }
                
                $cleaned++;
                $this->info("✅ Stream {$stream->id} limpiado");
                
                Log::info("Stream falso limpiado", [
                    'stream_id' => $stream->id,
                    'user_id' => $stream->user_id,
                    'title' => $stream->title
                ]);
            } else {
                $this->info("✅ Stream {$stream->id} tiene archivos HLS válidos");
            }
        }
        
        if ($cleaned > 0) {
            $this->info("🎉 {$cleaned} streams falsos limpiados");
        } else {
            $this->info("✅ Todos los streams live son válidos");
        }
    }
}
