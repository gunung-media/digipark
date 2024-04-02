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
        Schema::create('company_laid_offs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('response_worker')->nullable();
            $table->string('name');
            $table->string('position');
            $table->string('division');
            $table->date('start_contract');
            $table->date('end_contract')->nullable();
            $table->text('reason');
            $table->string('doc_joint_agreement')->nullable();
            $table->string('doc_not_rejecting_layoff')->nullable();
            $table->string('doc_layoff_notification')->nullable();
            $table->string('responsible_name');
            $table->string('responsible_position');
            $table->binary('signature')->nullable();
            $table->enum('status', ['diterima', 'diproses', 'ditunda', 'ditolak'])->nullable()->default('diterima');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_laid_offs');
    }
};
