<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('streams', function (Blueprint $table) {
            if (! Schema::hasColumn('streams', 'broadcast_mode')) {
                $table->string('broadcast_mode', 20)->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('streams', function (Blueprint $table) {
            if (Schema::hasColumn('streams', 'broadcast_mode')) {
                $table->dropColumn('broadcast_mode');
            }
        });
    }
};
