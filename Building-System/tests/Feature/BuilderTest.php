<?php

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

uses(RefreshDatabase::class);

// -------------------------
// index()
// -------------------------

test('builder index page loads successfully', function () {
    $this->get(route('builder.index'))
        ->assertOk()
        ->assertViewIs('builder.builder')
        ->assertViewHas('categories')
        ->assertViewHas('products')
        ->assertViewHas('errors');
});

// -------------------------
// storeItem()
// -------------------------

test('storeItem adds a component to the session cart', function () {
    $this->post(route('builder.storeItem', ['category' => 'cpu', 'product' => '1']))
        ->assertRedirect();

    $cart = session()->get('Builder.cart');
    expect($cart->hasItem('cpu'))->toBeTrue();
});

test('storeItem redirects back with error for invalid category', function () {
    $this->post(route('builder.storeItem', ['category' => 'invalid-category', 'product' => '1']))
        ->assertRedirect()
        ->assertSessionHasErrors();
});

test('storeItem stores compatibility errors in session', function () {
    $this->post(route('builder.storeItem', ['category' => 'cpu', 'product' => '1']));

    expect(session()->get('Builder.errors'))->toBeArray();
});

test('storeItem redirects to custom return url when provided', function () {
    $this->post(route('builder.storeItem', ['category' => 'cpu', 'product' => '1']), [
        'return' => '/custom-url'
    ])->assertRedirect('/custom-url');
});

test('storeItem redirects to builder index by default', function () {
    $this->post(route('builder.storeItem', ['category' => 'cpu', 'product' => '1']))
        ->assertRedirect(route('builder.index'));
});

// -------------------------
// remove()
// -------------------------

test('remove deletes component from session cart', function () {
    // First add a cpu
    $this->post(route('builder.storeItem', ['category' => 'cpu', 'product' => '1']));

    // Then remove it
    $this->delete(route('builder.remove', ['category' => 'cpu', 'product' => '1']))
        ->assertRedirect(route('builder.index'))
        ->assertSessionHas('success');

    $cart = session()->get('Builder.cart');
    expect($cart->hasItem('cpu'))->toBeFalse();
});

test('remove updates compatibility errors in session after removal', function () {
    $this->post(route('builder.storeItem', ['category' => 'cpu', 'product' => '1']));
    $this->delete(route('builder.remove', ['category' => 'cpu', 'product' => '1']));

    expect(session()->get('Builder.errors'))->toBeArray();
});

// -------------------------
// allBuild()
// -------------------------

test('all builds page loads successfully', function () {
    $this->get(route('builder.builds'))
        ->assertOk()
        ->assertViewIs('builder.build')
        ->assertViewHas('builds');
});

// -------------------------
// store() — save a build
// -------------------------

test('store saves a build to the database', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();
    $product2 = Product::factory()->create();

    $this->actingAs($user)->post(route('builder.save'), [
        'name' => 'My Test Build',
        'products' => [
            'cpu'  => [['id' => $product->id, 'count' => 1]],
            'ram'  => [['id' => $product2->id, 'count' => 2]],
        ]
    ])->assertRedirect(route('builder.index'));

    $this->assertDatabaseHas('builds', [
        'name'    => 'My Test Build',
        'user_id' => $user->id,
    ]);
});

test('store marks build as incomplete when categories are missing', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $this->actingAs($user)->post(route('builder.save'), [
        'name' => 'Incomplete Build',
        'products' => [
            'cpu' => [['id' => $product->id, 'count' => 1]],
            // missing ram, gpu, psu, motherboard, storage, case, cpu-cooler
        ]
    ]);

    $this->assertDatabaseHas('builds', [
        'name'       => 'Incomplete Build',
        'isComplete' => false,
    ]);
});
