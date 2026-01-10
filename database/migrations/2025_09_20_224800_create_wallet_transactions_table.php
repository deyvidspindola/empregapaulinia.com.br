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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();

            $table->enum('type', ['credit', 'debit']);
            $table->unsignedBigInteger('amount'); // sempre > 0

            $table->string('reason')->nullable(); // ex.: 'purchase', 'job_highlight'
            $table->unsignedBigInteger('actor_user_id')->nullable(); // quem executou
            $table->json('meta')->nullable();     // ex.: {"job_posting_id": 123}

            $table->unsignedBigInteger('balance_after'); // saldo após a transação (snapshot)
            $table->timestamps();

            $table->index(['wallet_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
