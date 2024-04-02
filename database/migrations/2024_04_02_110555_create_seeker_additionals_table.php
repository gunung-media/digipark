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
        Schema::create('seeker_additionals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seeker_id');
            $table->string('identity_number')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('bpjs_number')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('doc_ktp')->nullable();
            $table->string('doc_bpjs_card')->nullable();
            $table->string('doc_cv')->nullable();
            $table->binary('signature')->nullable();
            $table->timestamps();

            $table->foreign('seeker_id')->references('id')->on('seekers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seeker_additionals');
    }
};
