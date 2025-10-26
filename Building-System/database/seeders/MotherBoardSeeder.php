<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MotherBoard;

class MotherBoardSeeder extends Seeder
{
    public function run(): void
    {
        MotherBoard::factory()->count(10)->create();
    }
}
