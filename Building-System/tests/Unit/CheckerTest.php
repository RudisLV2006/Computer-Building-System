<?php

use App\CompactibilityChecker;
use App\Build;
use App\Models\CPUSpec;
use App\Models\MotherBoardSpec;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('it returns validation errors as array', function () {
    $build = new Build();

    $cpu = CpuSpec::factory()
        ->for(Product::factory()->create(['type' => 'cpu']), 'product')
        ->create();
    $motherboard = MotherboardSpec::factory()
        ->for(Product::factory()->create(['type' => 'motherboard']), 'product')
        ->create();

    $build->addItem($cpu->product->type, $cpu->product_id);
    $build->addItem($motherboard->product->type, $motherboard->product_id);

    $checker = new CompactibilityChecker($build);

    $errors = $checker->validate();

    expect($errors)->toBeArray();
});

test('filter returns builder instance', function () {
    $build = new Build();

    $checker = new CompactibilityChecker($build);

    $query = \App\Models\CpuSpec::query();

    $result = $checker->filter('cpu', $query);

    expect($result)->toBe($query);
});
test('filter applies rules based on build context', function () {
    $build = new Build();

    $cpu = CpuSpec::factory()
        ->for(Product::factory()->create(['type' => 'cpu']), 'product')
        ->create();
    $motherboard = MotherboardSpec::factory()
        ->for(Product::factory()->create(['type' => 'motherboard']), 'product')
        ->create();

    $build->addItem($cpu->product->type, $cpu->product_id);
    $build->addItem($motherboard->product->type, $motherboard->product_id);

    $checker = new CompactibilityChecker($build);

    $query = CPUSpec::query();

    $filtered = $checker->filter('cpu', $query);

    expect($filtered)->toBe($query);
});

test('cpu filter restricts incompatible sockets', function () {
    $build = new Build();

    $cpu = CpuSpec::factory()
        ->for(Product::factory()->create(['type' => 'cpu']), 'product')
        ->create(['socket' => 'test']);
    $motherboard = MotherboardSpec::factory()
        ->for(Product::factory()->create(['type' => 'motherboard']), 'product')
        ->create(['socket' => 'dont']);
    $build->addItem($cpu->product->type, $cpu->product_id);
    $build->addItem($motherboard->product->type, $motherboard->product_id);

    $checker = new CompactibilityChecker($build);

    $query = CPUSpec::query();

    $checker->filter('cpu', $query);

    $sql = $query->toSql();

    expect($sql)->toContain('where');
});

test('loadProducts returns products grouped by type', function () {
    $build = new Build();
    $cpu = CpuSpec::factory()
        ->for(Product::factory()->create(['type' => 'cpu']), 'product')
        ->create();
    $motherboard = MotherboardSpec::factory()
        ->for(Product::factory()->create(['type' => 'motherboard']), 'product')
        ->create();
    $build->addItem('cpu', $cpu->product_id);
    $build->addItem('motherboard', $motherboard->product_id);
    $result = $build->loadProducts();
    expect($result)->toHaveKey('cpu')
        ->and($result)->toHaveKey('motherboard')
        ->and($result['cpu']->first()['product']->id)->toBe($cpu->product_id)
        ->and($result['motherboard']->first()['product']->id)->toBe($motherboard->product_id);
});
