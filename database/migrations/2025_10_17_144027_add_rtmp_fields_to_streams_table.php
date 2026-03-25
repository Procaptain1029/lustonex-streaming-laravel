<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('streams', function (Blueprint $table) {
            // Solo agregar campos que no existen
            if (!Schema::hasColumn('streams', 'hls_url')) {
                $table->string('hls_url')->nullable()->after('rtmp_url');
            }
            if (!Schema::hasColumn('streams', 'recording_path')) {
                $table->string('recording_path')->nullable()->after('playback_url');
            }
            if (!Schema::hasColumn('streams', 'has_recording')) {
                $table->boolean('has_recording')->default(false)->after('recording_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('streams', function (Blueprint $table) {
            $table->dropColumn([
                'stream_key',
                'rtmp_url', 
                'hls_url',
                'recording_path',
                'has_recording'
            ]);
        });
    }
};
