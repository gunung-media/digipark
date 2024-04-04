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
            $table->dropColumn('year');
            $table->date('date_in')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('info_employments', function (Blueprint $table) {
            $table->string('year');
            $table->dropColumn('date_in');
        });
    }
};
