<?php

namespace Database\Factories;

use App\Models\PsuSpec;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends Factory<PsuSpec>
 */
class PsuSpecFactory extends Factory
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
                    'type' => 'psu',
                ])->id;
            },
            'manufacturer' => fake()->randomElement(['Corsair', 'EVGA', 'Seasonic', 'be quiet!', 'NZXT']),
            'psu_type' => fake()->randomElement(['ATX', 'SFX', 'SFX-L']),
            'wattage_w' => fake()->randomElement([550, 650, 750, 850, 1000, 1200]),
            'length' => fake()->randomElement([140, 150, 160, 180, 200]),
            'modular' => fake()->randomElement(['Full', 'Semi', 'Non']),
            'atx_4pin_connectors' => fake()->randomElement([0, 1]),
            'eps_8pin_connectors' => fake()->randomElement([1, 2]),
            'pcie_16pin_12vhpwr_connectors' => fake()->randomElement([0, 1]),
            'pcie_12pin_connectors' => 0,
            'pcie_8pin_connectors' => fake()->randomElement([0, 1, 2]),
            'pcie_6plus2pin_connectors' => fake()->randomElement([2, 3, 4]),
            'pcie_6pin_connectors' => fake()->randomElement([0, 1, 2]),
            'sata_connectors' => fake()->randomElement([4, 6, 8]),
            'molex_4pin_connectors' => fake()->randomElement([0, 2, 4]),
        ];
    }
}
