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
        Schema::table('seekers', function (Blueprint $table) {
            $table->string('password_raw')->nullable();
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->string('password_raw')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seekers', function (Blueprint $table) {
            $table->dropColumn('password_raw');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('password_raw');
        });
    }
};
