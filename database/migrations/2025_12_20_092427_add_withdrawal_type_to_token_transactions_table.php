<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the enum to include 'withdrawal'
        DB::statement("ALTER TABLE `token_transactions` MODIFY COLUMN `type` ENUM('purchase', 'spent', 'earned', 'refund', 'withdrawal') NOT NULL DEFAULT 'purchase'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'withdrawal' from enum
        DB::statement("ALTER TABLE `token_transactions` MODIFY COLUMN `type` ENUM('purchase', 'spent', 'earned', 'refund') NOT NULL DEFAULT 'purchase'");
    }
};
