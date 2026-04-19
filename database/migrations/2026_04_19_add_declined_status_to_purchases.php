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
        // Change the enum to include 'declined' and 'work_submitted'
        Schema::table('purchases', function (Blueprint $table) {
            $table->enum('status', ['pending', 'accepted', 'work_submitted', 'completed', 'cancelled', 'declined'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->enum('status', ['pending', 'accepted', 'completed', 'cancelled'])->default('pending')->change();
        });
    }
};
