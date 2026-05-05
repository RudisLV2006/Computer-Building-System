<?php
// tests/Feature/BuildSaveTest.php

use App\Models\User;
use App\Models\Builds;
use App\Models\CpuSpec;
use App\Models\MotherboardSpec;
use App\Models\Product;
use App\Models\RamSpec;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

it('saglabā build ar visiem komponentiem datubāzē', function () {
    $user = User::factory()->create();

    $cpu = CpuSpec::factory()
        ->for(Product::factory()->create(['type' => 'motherboard']), 'product')
        ->create();
    $motherboard = MotherboardSpec::factory()
        ->for(Product::factory()->create(['type' => 'motherboard']), 'product')
        ->create();

    $ram = RamSpec::factory()
        ->for(Product::factory()->create(['type' => 'motherboard']), 'product')
        ->create();

    $response = $this->actingAs($user)->post('/builder/save', [
        'name' => 'Mans spēļu dators',
        'products' => [
            'cpu' => [
                ['id' => $cpu->product_id, 'count' => 1],
            ],
            'motherboard' => [
                ['id' => $motherboard->product_id, 'count' => 1],
            ],
            'ram' => [
                ['id' => $ram->product_id, 'count' => 2],
            ],
        ],
    ]);

    // Pārbauda, vai novirza uz pareizo lapu
    $response->assertRedirect(route('builder.index'));

    // Pārbauda, vai Build tika saglabāts
    expect(
        Builds::where('name', 'Mans spēļu dators')
            ->where('user_id', $user->id)
            ->exists()
    )->toBeTrue();

    // Pārbauda, vai visi items tika saglabāti
    $build = Builds::where('user_id', $user->id)->first();

    expect($build->items)->toHaveCount(3);

    expect($build->items->where('category', 'cpu')->first())
        ->product_id->toBe(1)
        ->count->toBe(1);

    expect($build->items->where('category', 'ram')->first())
        ->count->toBe(2);
});

it('saglabā build kā nepilnu ja trūkst kategorija', function () {
    $user = User::factory()->create();

    $cpu = CpuSpec::factory()
        ->for(Product::factory()->create(['type' => 'motherboard']), 'product')
        ->create();
    $motherboard = MotherboardSpec::factory()
        ->for(Product::factory()->create(['type' => 'motherboard']), 'product')
        ->create();

    $ram = RamSpec::factory()
        ->for(Product::factory()->create(['type' => 'motherboard']), 'product')
        ->create();


    $this->actingAs($user)->post('/builder/save', [
        'name' => 'Dators',
        'products' => [
            'cpu' => [['id' => $cpu->product_id, 'count' => 1]],
            'motherboard' => [['id' => $motherboard->product_id, 'count' => 1]],
            'ram' => [['id' => $ram->product_id, 'count' => 2]],
        ],
    ]);

    $build = Builds::where('user_id', $user->id)->first();
    expect($build->isComplete)->toBe(0);
});
