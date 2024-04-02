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
        Schema::table('labor_demands', function (Blueprint $table) {
            $table->enum('status', ['diterima', 'diproses', 'ditunda', 'ditolak'])->nullable()->default('diterima');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('labor_demands', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
