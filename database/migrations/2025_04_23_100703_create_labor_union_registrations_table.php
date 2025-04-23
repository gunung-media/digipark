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
        Schema::create('labor_union_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('requester_name');
            $table->string('requester_position');
            $table->string('labor_union_name');
            $table->string('labor_union_location');
            $table->string('labor_union_address');
            $table->string('phone_number');
            $table->string('company_email')->nullable();
            $table->string('labor_union_email')->nullable();

            $table->string('doc_member_list');
            $table->string('doc_budget');
            $table->string('doc_arrangment');
            $table->string('doc_photocopies');

            $table->binary('signature')->nullable();
            $table->enum('status', ['diterima', 'diproses', 'ditunda', 'ditolak', 'selesai'])->nullable()->default('diterima');
            $table->unsignedBigInteger('company_id');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labor_union_registrations');
    }
};
