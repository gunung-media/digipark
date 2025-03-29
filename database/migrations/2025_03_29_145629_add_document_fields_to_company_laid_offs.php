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
        Schema::table('company_laid_offs', function (Blueprint $table) {
            $table->string('doc_participant_card')->nullable();
            $table->string('doc_bpjs_card')->nullable();
            $table->string('doc_identity_card')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_laid_offs', function (Blueprint $table) {
            $table->dropColumn('doc_participant_card');
            $table->dropColumn('doc_bpjs_card');
            $table->dropColumn('doc_identity_card');
        });
    }
};
