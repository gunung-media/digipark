<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $tables = [
            'company_laid_offs',
            'jobs',
            'company_legalizations',
            'labor_demands',
            'placements',
            'claim_jhts' // Ensure the correct table name
        ];

        foreach ($tables as $table) {
            // Check if the 'status' column exists before modifying
            if (Schema::hasColumn($table, 'status')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->enum('new_status', ['diterima', 'diproses', 'ditunda', 'ditolak', 'selesai'])->nullable()->default('diterima');
                });

                // Copy old values to the new column
                DB::statement("UPDATE {$table} SET new_status = status");

                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('status');
                    $table->renameColumn('new_status', 'status');
                });
            }
        }
    }

    public function down()
    {
        $tables = [
            'company_laid_offs',
            'jobs',
            'company_legalizations',
            'labor_demands',
            'placements',
            'claim_jhts'
        ];

        foreach ($tables as $table) {
            if (Schema::hasColumn($table, 'status')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->enum('new_status', ['diterima', 'diproses', 'ditunda', 'ditolak'])->nullable()->default('diterima');
                });

                DB::statement("UPDATE {$table} SET new_status = status");

                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('status');
                    $table->renameColumn('new_status', 'status');
                });
            }
        }
    }
};
