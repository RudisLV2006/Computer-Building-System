<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MotherBoardSpec;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MotherBoardSpec>
 */
class MotherBoardFactory extends Factory
{
    protected $model = MotherBoardSpec::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => function () {
                return Product::factory()->create([
                    'type' => 'motherboard',
                ])->id;
            },
            'manufacturer' => $this->faker->randomElement([
                'ASUS', 'Gigabyte', 'MSI', 'ASRock', 'Biostar'
            ]),

            'series' => $this->faker->word(), // or something like 'ROG', 'AORUS'
            'socket' => $this->faker->randomElement([
                'LGA1200', 'AM4', 'LGA1700', 'TR4', 'LGA1151'
            ]),

            'chipset' => $this->faker->randomElement([
                'Z590', 'B550', 'X570', 'H470', 'Z690'
            ]),

            'memory_technology' => $this->faker->randomElement([
                'DDR4', 'DDR5'
            ]),

            'form_factor' => $this->faker->randomElement([
                'ATX', 'Micro-ATX', 'Mini-ITX', 'E-ATX'
            ]),
        ];
    }
}
