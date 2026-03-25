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
        Schema::table('missions', function (Blueprint $table) {
            $table->enum('role', ['fan', 'model', 'both'])->default('both')->after('type');
            $table->unsignedBigInteger('level_id')->nullable()->after('role');
            
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->dropForeign(['level_id']);
            $table->dropColumn(['role', 'level_id']);
        });
    }
};
