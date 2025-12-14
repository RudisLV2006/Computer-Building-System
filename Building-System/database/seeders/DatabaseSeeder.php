<?php

namespace Database\Seeders;

use App\Models\MotherboardSpec;
use App\Models\CpuSpec;
use App\Models\RamSpec;
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
        $count = 10;
        MotherboardSpec::factory()
            ->count($count)
            ->create();
        CpuSpec::factory()
            ->count($count)
            ->create();
        RamSpec::factory()
            ->count($count)
            ->create();
    }
}
