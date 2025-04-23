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
        Schema::create('institutional_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('permission_number');
            $table->date('permission_date');
            $table->string('bpjs_number');

            $table->integer('male_employee');
            $table->integer('female_employee');

            $table->string('doc_bap');
            $table->string('doc_proofment');
            $table->string('doc_administrator');

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
        Schema::dropIfExists('institutional_approvals');
    }
};
