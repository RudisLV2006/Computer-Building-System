<?php

namespace Database\Factories;

use App\Models\CaseSpec;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends Factory<CaseSpec>
 */
class CaseSpecFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory()->state([
                'type' => 'case',
            ]),
            'manufacturer' => fake()->randomElement(['Fractal Design', 'NZXT', 'Lian Li', 'Corsair', 'be quiet!']),
            'case_type' => fake()->randomElement(['ATX Mid Tower', 'ATX Full Tower', 'mATX Mid Tower', 'ITX Desktop', 'ITX Tower']),
            'max_gpu_length_mm' => fake()->randomElement([300, 330, 360, 400]),
            'max_cooler_height_mm' => fake()->randomElement([150, 160, 165, 170]),
            'max_psu_length_mm' => fake()->randomElement([140, 150, 160, 180, null]),
            'height_mm' => fake()->numberBetween(380, 550),
            'length_mm' => fake()->numberBetween(380, 520),
            'width_mm' => fake()->numberBetween(180, 240),
        ];
    }
}
