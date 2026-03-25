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
            $table->string('pause_image')->nullable()->after('last_obs_connection');
            $table->string('pause_video')->nullable()->after('pause_image');
            $table->string('pause_mode')->default('none')->after('pause_video');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['pause_image', 'pause_video', 'pause_mode']);
        });
    }
};
