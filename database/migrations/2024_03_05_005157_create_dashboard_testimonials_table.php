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
        Schema::create('dashboard_testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('job')->nullable();
            $table->string('testimonial');
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(0);
            $table->foreignId('dashboard_id')->constrained('dashboards')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboard_testimonials');
    }
};
