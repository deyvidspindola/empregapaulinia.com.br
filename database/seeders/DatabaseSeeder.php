<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create(
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'role' => 'admin',
                'password' => bcrypt('senha@123'),
            ]
        );

        User::factory()->create(
            [
                'name' => 'Candidate',
                'email' => 'candidate@candidate.com',
                'role' => 'candidate',
                'password' => bcrypt('senha@123'),
            ]
        );

        User::factory()->create(
            [
                'name' => 'Employer',
                'email' => 'employer@employer.com',
                'role' => 'employer',
                'password' => bcrypt('senha@123'),
            ]
        );
    }
}
