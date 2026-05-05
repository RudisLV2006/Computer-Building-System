<?php
// tests/Feature/BuildSaveTest.php

use App\Models\User;
use App\Models\Builds;
use App\Models\Product;
use App\ProductTypeRegistry;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

it('saglabā build un isComplete ir false, ja trūkst kategorijas', function () {
    $user = User::factory()->create();

    // Produktam jāeksistē datubāzē!
    $cpu = Product::factory()->create(['type' => 'cpu']);

    $response = $this->actingAs($user)->post('/builder/save', [
        'name' => 'Nepilns dators',
        'products' => [
            'cpu' => [['id' => $cpu->id, 'count' => 1]],
            // trūkst gpu, ram, psu, mobo utt.
        ],
    ]);

    $response->assertRedirect(route('builder.index'));

    $build = Builds::where('user_id', $user->id)->first();

    expect($build->name)->toBe('Nepilns dators');
    expect($build->isComplete)->toBe(0);
    expect($build->items)->toHaveCount(1);
});

it('isComplete ir true tikai kad visas kategorijas ir aizpildītas', function () {
    $user = User::factory()->create();

    $allCategories = ProductTypeRegistry::all();

    // Katrai kategorijai izveidojam reālu produktu datubāzē
    $products = [];
    foreach ($allCategories as $category) {
        $product = Product::factory()->create(['type' => $category]);
        $products[$category] = [['id' => $product->id, 'count' => 1]];
    }

    $this->actingAs($user)->post('/builder/save', [
        'name'     => 'Pilns dators',
        'products' => $products,
    ]);

    $build = Builds::where('user_id', $user->id)->first();

    expect($build->isComplete)->toBe(1);
});
