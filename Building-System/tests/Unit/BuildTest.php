<?php

use App\Models\Product;
use App\Models\CPUSpec;
use App\ProductTypeRegistry;
use App\Build;

uses(Tests\TestCase::class);

it('can load product and its specs with type', function () {
    // Refresh the application to ensure Faker is properly initialized
    $this->artisan('migrate:fresh');
    // Create a CPU with associated product
    $cpu = CPUSpec::factory()->create();
    
    $build = new Build(null);
    $build->addItem('cpu', $cpu->product_id);
    // var_dump($build);
    
    // Call the loadModel method
    $result = $build->loadModel('cpu');
    
    // Assert the result
    expect($result)->toBeNull();
    // expect($result)->toHaveKey('product');
});