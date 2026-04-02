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
        // Add rating column to reviews table if it doesn't exist
        if (Schema::hasTable('reviews') && !Schema::hasColumn('reviews', 'rating')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->integer('rating')->default(5)->after('seller_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('reviews') && Schema::hasColumn('reviews', 'rating')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('rating');
            });
        }
    }
};
