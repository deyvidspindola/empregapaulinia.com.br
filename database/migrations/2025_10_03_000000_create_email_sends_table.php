<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('email_sends', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // recommended_jobs, lead_reactivation, etc
            $table->unsignedBigInteger('user_id')->nullable();
            $table->json('meta')->nullable(); // store job_ids, counts, etc
            $table->string('status')->default('sent'); // sent, failed
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['type', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_sends');
    }
};