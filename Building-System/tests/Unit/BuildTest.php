<?php

use App\Models\Product;
use App\Models\CPUSpec;
use App\ProductTypeRegistry;
use App\Build;

uses(Tests\TestCase::class);

it('can load product and its specs with type', function () {
    $this->artisan('migrate:fresh');
    
    $cpu = CPUSpec::factory()->create();
    
    $build = new Build(null);
    $build->addItem('cpu', $cpu->product_id);
    
    $result = $build->loadModel('cpu');
    
    expect($result)->not()->toBeNull();
    
    // Convert to array to check for 'product' key
    expect($result)->toHaveKey('product');
});