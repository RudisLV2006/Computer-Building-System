<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MotherBoard;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MotherBoard>
 */
class MotherBoardFactory extends Factory
{
    protected $model = MotherBoard::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'manufacturer' => $this->faker->randomElement(['ASUS', 'MSI', 'Gigabyte', 'ASRock', 'Biostar']),
            'series' => $this->faker->bothify('Series ###'),
            'socket' => $this->faker->randomElement(['AM4', 'LGA1200', 'LGA1700']),
            'chipset' => $this->faker->randomElement(['B550', 'Z690', 'B450', 'B760']),
            'memory_technology' => $this->faker->randomElement(['DDR4', 'DDR5']),
            'form_factor' => $this->faker->randomElement(['ATX', 'Micro-ATX', 'Mini-ITX']),
        ];
    }
}
