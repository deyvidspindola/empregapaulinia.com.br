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
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->constrained('job_categories')->restrictOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('job_type', ['CLT','PJ','Temporário','Estágio','Freelancer','Meio Período']);
            $table->string('location')->nullable();
            $table->decimal('salary', 12, 2)->nullable();
            $table->string('currency', 3)->default('BRL');
            $table->enum('modality', ['Presencial','Remoto','Híbrido'])->nullable();
            $table->enum('level', ['Júnior','Pleno','Sênior','Especialista','Líder'])->nullable();
            $table->date('deadline')->nullable();
            $table->unsignedInteger('openings')->default(1);
            $table->boolean('is_published')->default(true);
            $table->json('tags')->nullable();
            $table->text('description');
            $table->text('requirements');
            $table->text('benefits')->nullable();
            $table->text('observation')->nullable();
            $table->boolean('is_company_visible')->default(true);
            $table->enum('apply_method', ['platform', 'email'])->default('platform');
            $table->string('apply_email')->nullable();            
            $table->timestamps();
            $table->index(['is_published','deadline']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
