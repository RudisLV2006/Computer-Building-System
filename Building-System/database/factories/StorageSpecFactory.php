<?php

namespace Database\Factories;

use App\Models\StorageSpec;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends Factory<StorageSpec>
 */
class StorageSpecFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['SSD', 'HDD', 'NVMe']);
        $formFactor = match ($type) {
            'HDD' => '3.5"',
            'SSD' => '2.5"',
            'NVMe' => 'M.2',
        };

        $interface = match ($type) {
            'HDD', 'SSD' => 'SATA',
            'NVMe' => fake()->randomElement(['PCIe 3.0', 'PCIe 4.0']),
        };
        return [
            'product_id' => function () {
                return Product::factory()->create([
                    'type' => 'storage',
                ])->id;
            },
            'capacity_gb' => fake()->randomElement([256, 512, 1024, 2048, 4096]),
            'type' => $type,
            'form_factor' => $formFactor,
            'interface' => $interface,
        ];
    }
}
