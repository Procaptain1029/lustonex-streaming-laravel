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
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('stream_key')->unique()->nullable()->after('is_streaming');
            $table->boolean('obs_connected')->default(false)->after('stream_key');
            $table->timestamp('last_obs_connection')->nullable()->after('obs_connected');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['stream_key', 'obs_connected', 'last_obs_connection']);
        });
    }
};
