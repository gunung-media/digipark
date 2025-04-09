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
        Schema::table('info_employments', function (Blueprint $table) {
            $table->renameColumn('count', 'unemployed_count');
            $table->bigInteger('seeker_count')->nullable();
            $table->bigInteger('job_count')->nullable();
            $table->bigInteger('placement_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('info_employments', function (Blueprint $table) {
            $table->renameColumn('unemployed_count', 'count');
            $table->dropColumn('seeker_count');
            $table->dropColumn('job_count');
            $table->dropColumn('placement_count');
        });
    }
};
