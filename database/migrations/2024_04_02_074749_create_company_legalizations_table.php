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
        Schema::create('company_legalizations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('business_license_decision_letter')->nullable();
            $table->string('labor_union_names')->nullable();
            $table->string('bpjs_membership_number')->nullable();
            $table->integer('headquarters_male_employee_count')->nullable();
            $table->integer('headquarters_female_employee_count')->nullable();
            $table->integer('branch_male_employee_count')->nullable();
            $table->integer('branch_female_employee_count')->nullable();
            $table->integer('outsourced_male_employee_count')->nullable();
            $table->integer('outsourced_female_employee_count')->nullable();
            $table->string('company_regulation_concept')->nullable();
            $table->date('company_regulation_effective_date')->nullable();
            $table->bigInteger('minimum_monthly_wage')->nullable();
            $table->bigInteger('maximum_monthly_wage')->nullable();
            $table->bigInteger('minimum_daily_wage')->nullable();
            $table->bigInteger('maximum_daily_wage')->nullable();
            $table->integer('fixed_term_employment_system')->nullable();
            $table->integer('permanent_employment_system')->nullable();
            $table->string('doc_pp')->nullable();
            $table->string('doc_evidence_union_consultation_request')->nullable();
            $table->string('doc_union_consultation_statement')->nullable();
            $table->string('doc_no_union_declaration')->nullable();
            $table->string('doc_wage_structure_and_scale')->nullable();
            $table->string('doc_bpjs_membership_and_payment_copy')->nullable();
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
        Schema::dropIfExists('company_legalizations');
    }
};
