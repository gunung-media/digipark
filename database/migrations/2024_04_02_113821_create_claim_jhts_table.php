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
        Schema::create('claim_jhts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seeker_id');
            $table->enum('type', ['pengunduran_diri', 'pemutusan_hubungan_kerja']);
            $table->binary('signature')->nullable();
            $table->enum('status', ['diterima', 'diproses', 'ditunda', 'ditolak'])->nullable()->default('diterima');
            $table->timestamps();

            $table->foreign('seeker_id')->references('id')->on('seekers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claim_jhts');
    }
};
