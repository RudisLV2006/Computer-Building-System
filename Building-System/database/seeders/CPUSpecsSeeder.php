<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CPUSpecs;

class CPUSpecsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CPUSpecs::factory()
        ->count(5)
        ->create();
    }
}
