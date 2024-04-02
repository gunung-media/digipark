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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('company_type')->nullable();
            $table->enum('company_status', [
                'pt',
                'cv',
                'perorangan',
                'badan usaha negara',
                'parsero',
                'pma',
                'perusahaan',
                'joint venture',
                'pmdn'
            ])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['company_type', 'company_status']);
        });
    }
};
