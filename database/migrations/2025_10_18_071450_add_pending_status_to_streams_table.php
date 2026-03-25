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
            // Modificar el ENUM para incluir 'pending'
            $table->enum('status', ['pending', 'live', 'paused', 'ended'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('streams', function (Blueprint $table) {
            // Revertir al ENUM original
            $table->enum('status', ['live', 'paused', 'ended'])->default('live')->change();
        });
    }
};
