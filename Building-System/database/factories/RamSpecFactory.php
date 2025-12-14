<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RamSpec>
 */
class RamSpecFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $memoryType = $this->faker->randomElement(['DDR4', 'DDR5']);

        return [
            'product_id' => function () {
                return Product::factory()->create([
                    'type' => 'ram',
                ])->id;
            },

            'manufacturer' => $this->faker->randomElement([
                'Corsair',
                'G.Skill',
                'Kingston',
                'Crucial',
                'ADATA',
                'TeamGroup',
            ]),

            'series' => $this->faker->randomElement([
                'Vengeance',
                'Trident Z',
                'Fury',
                'Ripjaws',
                'Ballistix',
                'XPG Lancer',
            ]),

            'memory_type' => $memoryType,

            'capacity_gb' => $this->faker->randomElement([8, 16, 32, 64]),
            'modules' => $this->faker->randomElement([1, 2]),

            'speed_mhz' => $memoryType === 'DDR5'
                ? $this->faker->randomElement([4800, 5200, 5600, 6000, 6400])
                : $this->faker->randomElement([2666, 3000, 3200, 3600]),

            'base_speed_mhz' => $memoryType === 'DDR5' ? 4800 : 2133,

            'cas_latency' => $memoryType === 'DDR5'
                ? $this->faker->randomElement([28, 30, 32, 36])
                : $this->faker->randomElement([14, 16, 18]),

            'voltage_v' => $memoryType === 'DDR5' ? 1.10 : 1.35,
        ];
    }
}
