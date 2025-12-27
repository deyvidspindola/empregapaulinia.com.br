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
        Schema::create('job_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['is_active', 'sort_order']);
        });
        $now  = now();
        $cats = [
            'Suporte Administrativo',
            'Atendimento ao Cliente',
            'Análise de Dados',
            'Design & Criação',
            'Jurídico',
            'Desenvolvimento de Software',
            'TI & Redes',
            'Redação',
            'Tradução',
            'Vendas & Marketing',
        ];

        DB::table('job_categories')->insert(
            array_map(fn ($name, $i) => [
                'name'        => $name,
                'slug'        => Str::slug($name),
                'sort_order'  => $i + 1,
                'is_active'   => true,
                'created_at'  => $now,
                'updated_at'  => $now,
            ], $cats, array_keys($cats))
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_categories');
    }
};
