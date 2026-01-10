<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();           // armazena string/json
            $table->string('type')->default('string');       // string|int|bool|json
            $table->timestamps();
        });

        // Valores iniciais
        $now = now();

        DB::table('settings')->insert([
            [
                'key'        => 'initial_credits',
                'value'      => '30',        // string, mas type=int
                'type'       => 'int',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'highlight_costs',
                'value'      => json_encode(['7'=>10,'15'=>18,'30'=>32], JSON_UNESCAPED_UNICODE),
                'type'       => 'json',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'default_highlight_days',
                'value'      => '7',
                'type'       => 'int',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'home_min_cards',
                'value'      => '8',
                'type'       => 'int',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'home_fill_random',
                'value'      => '1',         // "1" = true
                'type'       => 'bool',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
