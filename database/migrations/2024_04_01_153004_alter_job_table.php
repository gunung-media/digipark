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
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('jobs', function (Blueprint $table) {
            $table->binary('signature')->nullable();
            $table->boolean('is_active')->default(false)->after('name_job');
            $table->enum('status', ['diterima', 'diproses', 'ditunda', 'ditolak'])->nullable()->default('diterima');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('signature');
            $table->renameColumn('is_active', 'status');
        });
    }
};
