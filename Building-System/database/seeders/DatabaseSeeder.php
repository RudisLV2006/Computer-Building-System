<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MotherBoardSpec;
use App\Models\CPUSpec;
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
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        MotherBoardSpec::factory()
        ->count(5)
        ->create();
        CPUSpec::factory()
        ->count(5)
        ->create();
    }
}
