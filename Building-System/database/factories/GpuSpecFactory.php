<?php

namespace Database\Factories;

use App\Models\GpuSpec;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends Factory<GpuSpec>
 */
class GpuSpecFactory extends Factory
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
                    'type' => 'gpu',
                ])->id;
            },
            'manufacturer' => fake()->randomElement(['Nvidia', 'AMD', 'Intel']),
            'chipset' => fake()->randomElement(['RTX 4090', 'RTX 4070', 'RX 7900 XT', 'RX 7600']),
            'memory' => fake()->randomElement([8, 12, 16, 24]),
            'core_clock_mhz' => fake()->numberBetween(1500, 2800),
            'pcie_version' => fake()->randomElement([3, 4, 5]),
            'pcie_lanes' => 16,
            'length' => fake()->numberBetween(200, 340),
            'wattage_w' => fake()->randomElement([150, 200, 250, 300, 350, 450]),
            'pcie_8pin_count' => fake()->randomElement([0, 1, 2]),
            'pcie_6pin_count' => fake()->randomElement([0, 1]),
            'has_12vhpwr' => fake()->boolean(20), // 20% chance true
        ];
    }
}
