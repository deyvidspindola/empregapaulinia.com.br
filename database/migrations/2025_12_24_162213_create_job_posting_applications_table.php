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
        Schema::create('job_posting_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_posting_id')->constrained('job_postings')->cascadeOnDelete();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // candidato
            $table->enum('method', ['platform','email'])->default('platform');
            $table->enum('status',['submitted','viewed','shortlisted','rejected'])->default('submitted');
            $table->text('cover_letter')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('emailed_to')->nullable();
            $table->timestamp('emailed_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['company_id', 'method']);
            $table->unique(['job_posting_id','user_id']); // 1 candidatura por vaga
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posting_applications');
    }
};
