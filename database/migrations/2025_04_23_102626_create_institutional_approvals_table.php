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
            $table->string('company_name');
            $table->string('name');
            $table->string('phone');
            $table->string('company_type');
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
            $table->string('permission_number');
            $table->date('permission_date');
            $table->string('bpjs_number');

            $table->integer('male_employee');
            $table->integer('female_employee');

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
