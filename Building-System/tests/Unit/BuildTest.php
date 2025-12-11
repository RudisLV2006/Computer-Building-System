<?php

use App\Models\Product;
use App\Models\CPUSpec;
use App\Models\MotherBoardSpec;
use App\ProductTypeRegistry;
use App\Build;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('can load CPU and its specs with type', function () {
    $type = 'cpu';
    $productId = 1;

    // Seed product with the exact ID
    Product::factory()->create([
        'id' => $productId,
        'type' => $type,
    ]);

    // Seed cpu_specs for this product
    CpuSpec::factory()->create([
        'product_id' => $productId
    ]);

    $build = new Build(null);
    $build->addItem($type, $productId);
    
    $result = $build->loadModel($type);
    // dd($result);
    
    expect($result)->not()->toBeNull();
    
    // Convert to array to check for 'product' key
    expect($result)->toHaveKey('product');
});

it('can load motherboard and its specs with type', function () {
    $type = 'mobo';
    $productId = 1;

    // Seed product with the exact ID
    Product::factory()->create([
        'id' => $productId,
        'type' => $type,
    ]);

    // Seed cpu_specs for this product
    MotherBoardSpec::factory()->create([
        'product_id' => $productId
    ]);

    $build = new Build(null);
    $build->addItem($type, $productId);
    
    $result = $build->loadModel($type);
    
    expect($result)->not()->toBeNull();
    
    // Convert to array to check for 'product' key
    expect($result)->toHaveKey('product');
});

test('build has type', function () {
    $type = 'mobo';
    $productId = 1;

    $build = new Build(null);
    $build->addItem($type, $productId);

    $result = $build->hasItem($type);
    
    expect($result)->toBeTrue();
});

test('build wrong type input', function () {
    $type = 'mobo';
    $productId = 1;

    $build = new Build(null);
    $build->addItem("cpu", $productId);

    $result = $build->hasItem($type);
    
    expect($result)->toBeFalse();
});

it('can get product specs', function () {
    $type = 'cpu';
    $productId = 1;

    // Seed product with the exact ID
    Product::factory()->create([
        'id' => $productId,
        'type' => $type,
    ]);

    // Seed cpu_specs for this product
    CpuSpec::factory()->create([
        'product_id' => $productId
    ]);

    $build = new Build(null);
    $build->addItem($type, $productId);

    $result = $build->getSpec($type);
    
    expect($result)->not()->toBeNull();
    expect($result)->toHaveKey('product');
});

it('can not get product specs because false type', function () {
    $type = 'cpu';
    $productId = 1;

    // Seed product with the exact ID
    Product::factory()->create([
        'id' => $productId,
        'type' => $type,
    ]);

    // Seed cpu_specs for this product
    CpuSpec::factory()->create([
        'product_id' => $productId
    ]);

    $build = new Build(null);
    $build->addItem("mobo", $productId);

    $result = $build->getSpec($type);
    
    expect($result)->toBeNull();
});

it('returns null when trying to load a non-existing product', function () {
    $build = new Build(null);
    $build->addItem('cpu', 999); // ID does not exist

    $result = $build->loadModel('cpu');

    expect($result)->toBeNull();
});

it('overwrites an item when adding same type twice', function () {
    $build = new Build(null);

    $build->addItem('cpu', 1);
    $build->addItem('cpu', 2);

    $items = $build->getItems();

    expect($items['cpu'])->toBe(['product_id' => 2]);
});

