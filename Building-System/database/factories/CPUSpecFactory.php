<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CPUSpecs>
 */
class CpuSpecFactory extends Factory
{
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
                    'type' => 'cpu',
                ])->id;
            },
            'manufacturer' => $this->faker->randomElement([
                'AMD',
                'INTEL',
            ]),
            'series' => $this->faker->word(),
            'socket' => $this->faker->randomElement([
                'LGA1200',
                'AM4',
                'LGA1700',
                'TR4',
                'LGA1151'
            ]),
            'cpu_speed_ghz' => $this->faker->randomFloat(1, 3, 9),
            'wattage_w' => $this->faker->randomNumber(2, true),
        ];
    }
}
