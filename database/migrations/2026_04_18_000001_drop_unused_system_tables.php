<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop unused Laravel system tables
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tables are dropped and cannot be easily restored
        // Restore from a backup if needed
    }
};
