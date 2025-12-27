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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unique('user_id');
            $table->string('full_name', 255);
            $table->string('cpf', 14)->unique();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['Male','Female','Other','Prefer not to say'])->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('zip', 9)->nullable();
            $table->string('street', 255)->nullable();
            $table->string('number', 20)->nullable();
            $table->string('complement', 100)->nullable();
            $table->string('neighborhood', 120)->nullable();
            $table->string('city', 120)->nullable();
            $table->string('state', 2)->nullable();
            $table->string('logo_path', 255)->nullable();
            $table->string('resume_path', 255)->nullable();
            $table->index('zip');
            $table->index(['city', 'state']);            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
