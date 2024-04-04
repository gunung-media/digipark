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
        Schema::table('claim_jhts', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::create('track_claim_jhts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('claim_jht_id')->constrained('claim_jhts');
            $table->enum('status', ['diproses', 'ditunda', 'ditolak']);
            $table->string('file')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('claim_jhts', function (Blueprint $table) {
            $table->enum('status', ['diterima', 'diproses', 'ditunda', 'ditolak'])->nullable()->default('diterima');
        });

        Schema::dropIfExists('track_claim_jhts');
    }
};
