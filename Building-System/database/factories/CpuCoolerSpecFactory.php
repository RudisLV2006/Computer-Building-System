<?php

namespace Database\Factories;

use App\Models\CoolerSocket;
use App\Models\CpuCoolerSpec;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends Factory<CpuCoolerSpec>
 */
class CpuCoolerSpecFactory extends Factory
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
                'type' => 'cpu-cooler',
            ]),
            'manufacturer' => fake()->randomElement(['Noctua', 'be quiet!', 'Cooler Master', 'Arctic', 'DeepCool']),
            'wattage_w' => fake()->randomElement([5, 7, 10, 15]),
            'height_mm' => fake()->randomElement([120, 150, 155, 158, 165]),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function ($cooler) {
            $sockets = fake()->randomElements(['AM4', 'AM5', 'LGA1700', 'LGA1200'], rand(1, 3), false);
            foreach ($sockets as $socket) {
                CoolerSocket::create([
                    'cooler_id' => $cooler->product_id,
                    'socket' => $socket,
                ]);
            }
        });
    }
}
