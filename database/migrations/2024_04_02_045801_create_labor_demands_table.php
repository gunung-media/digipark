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
        Schema::create('labor_demands', function (Blueprint $table) {
            $table->id();
            $table->date('request_deadline')->nullable();
            $table->string('name_job');
            $table->integer('total_man_needs')->nullable();
            $table->integer('total_woman_needs')->nullable();
            $table->string('education');
            $table->string('major');
            $table->text('skills')->nullable();
            $table->text('experience')->nullable();
            $table->text('special_conditions')->nullable();
            $table->string('wage_system');
            $table->string('salary');
            $table->string('work_status');
            $table->string('total_hours_per_week');
            $table->json('social_guarantee');
            $table->text('work_description');
            $table->binary('signature');
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
        Schema::dropIfExists('labor_demands');
    }
};
