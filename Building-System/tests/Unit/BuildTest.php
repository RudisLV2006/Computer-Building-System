<?php

use App\Build;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    config([
        'builder.categories' => [
            'cpu' => \App\Models\CpuSpec::class,
            'ram' => \App\Models\RamSpec::class,
            'gpu' => \App\Models\GpuSpec::class,
        ],
        'builder.multiple_allowed' => ['ram'], // ram is multi, cpu/gpu are single
    ]);
});

// -------------------------
// __construct()
// -------------------------

test('initializes with empty items when no previous build given', function () {
    $build = new Build();

    expect($build->items)->toBe([]);
});

test('copies items from previous build', function () {
    $old = new Build();
    $old->items = ['cpu' => ['1' => ['product_id' => '1', 'count' => 1]]];

    $new = new Build($old);

    expect($new->items)->toBe($old->items);
});

// -------------------------
// addItem()
// -------------------------

test('addItem adds a single-select component', function () {
    $build = new Build();
    $build->addItem('cpu', '5');

    expect($build->items['cpu']['5'])->toBe(['product_id' => '5', 'count' => 1]);
});

test('addItem replaces previous single-select component in same category', function () {
    $build = new Build();
    $build->addItem('cpu', '5');
    $build->addItem('cpu', '9');

    expect($build->items['cpu'])->toHaveCount(1)
        ->and($build->items['cpu'])->toHaveKey('9')
        ->and($build->items['cpu'])->not->toHaveKey('5');
});

test('addItem increments count for multiple-select component', function () {
    $build = new Build();
    $build->addItem('ram', '3');
    $build->addItem('ram', '3');

    expect($build->items['ram']['3']['count'])->toBe(2);
});

test('addItem allows multiple different items in multiple-select category', function () {
    $build = new Build();
    $build->addItem('ram', '1');
    $build->addItem('ram', '2');

    expect($build->items['ram'])->toHaveCount(2);
});

test('addItem keeps different categories independent', function () {
    $build = new Build();
    $build->addItem('cpu', '1');
    $build->addItem('gpu', '2');

    expect($build->items)->toHaveKeys(['cpu', 'gpu']);
});

// -------------------------
// removeItem()
// -------------------------

test('removeItem decrements count for multiple-select component', function () {
    $build = new Build();
    $build->addItem('ram', '3');
    $build->addItem('ram', '3');
    $build->removeItem('ram', '3');

    expect($build->items['ram']['3']['count'])->toBe(1);
});

test('removeItem removes item when count reaches zero', function () {
    $build = new Build();
    $build->addItem('cpu', '5');
    $build->removeItem('cpu', '5');

    expect($build->items)->not->toHaveKey('cpu');
});

test('removeItem removes category when it becomes empty', function () {
    $build = new Build();
    $build->addItem('cpu', '5');
    $build->removeItem('cpu', '5');

    expect($build->items)->not->toHaveKey('cpu');
});

test('removeItem does nothing when category does not exist', function () {
    $build = new Build();

    expect(fn() => $build->removeItem('cpu', '99'))->not->toThrow(Exception::class);
    expect($build->items)->toBe([]);
});

// -------------------------
// hasItem()
// -------------------------

test('hasItem returns true when category has a component', function () {
    $build = new Build();
    $build->addItem('cpu', '1');

    expect($build->hasItem('cpu'))->toBeTrue();
});

test('hasItem returns false when category is empty', function () {
    $build = new Build();

    expect($build->hasItem('cpu'))->toBeFalse();
});

test('hasItem returns false after item is removed', function () {
    $build = new Build();
    $build->addItem('cpu', '1');
    $build->removeItem('cpu', '1');

    expect($build->hasItem('cpu'))->toBeFalse();
});

// -------------------------
// __sleep()
// -------------------------

test('sleep excludes modelCache from serialization', function () {
    $build = new Build();

    expect($build->__sleep())->toBe(['items'])
        ->and($build->__sleep())->not->toContain('modelCache');
});

test('items survive serialization and unserialization', function () {
    $build = new Build();
    $build->addItem('cpu', '7');

    $restored = unserialize(serialize($build));

    expect($restored->items)->toBe($build->items);
});

test('modelCache is not present after unserialization', function () {
    $build = new Build();
    $build->addItem('cpu', '7');

    $restored = unserialize(serialize($build));

    expect(isset($restored->modelCache))->toBeFalse();
});
it('can remove item and delete category when empty', function () {
    $build = new Build(null);

    $build->addItem('cpu', 1);
    $build->removeItem('cpu', 1);

    expect($build->hasItem('cpu'))->toBeFalse();
});

it('decreases count when removing item but keeps it if count > 0', function () {
    $build = new Build(null);

    $build->addItem('ram', 1);
    $build->addItem('ram', 1); // count should now be 2

    $build->removeItem('ram', 1);

    $items = $build->getItems();

    expect($items['ram'][1]['count'])->toBe(1);
});

it('constructs build from previous build instance', function () {
    $original = new Build(null);
    $original->addItem('cpu', 1);

    $copy = new Build($original);

    expect($copy->hasItem('cpu'))->toBeTrue();
});

it('loadModel returns null when category not set', function () {
    $build = new Build(null);

    expect($build->loadModel('cpu'))->toBeNull();
});

it('loadProducts returns grouped products by type', function () {
    Product::factory()->create([
        'id' => 1,
        'type' => 'cpu',
    ]);

    Product::factory()->create([
        'id' => 2,
        'type' => 'motherboard',
    ]);

    $build = new Build(null);
    $build->addItem('cpu', 1);
    $build->addItem('motherboard', 2);

    $result = $build->loadProducts();

    expect($result->has('cpu'))->toBeTrue();
    expect($result->has('motherboard'))->toBeTrue();
});

it('overwrites non-multiple category correctly', function () {
    $build = new Build(null);

    $build->addItem('cpu', 1);
    $build->addItem('cpu', 2);

    $items = $build->getItems();

    expect(array_key_first($items['cpu']))->toBe(2);
});
