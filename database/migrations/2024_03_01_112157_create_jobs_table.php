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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('name_job');
            $table->text('description');
            $table->integer('total_needed_man')->default(0);
            $table->integer('total_needed_woman')->default(0);
            $table->string('minimal_education')->nullable();
            $table->text('special')->nullable();
            $table->integer('salary')->default(0);
            $table->date('deadline')->nullable();
            $table->date('start_date');
            $table->string('address');
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
