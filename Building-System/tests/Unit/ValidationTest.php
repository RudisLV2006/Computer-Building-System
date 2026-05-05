<?php
// tests/Unit/BuildValidationTest.php

use App\Models\User;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

function postBuild(array $data): Illuminate\Testing\TestResponse
{
    $user = User::factory()->create();
    return test()->actingAs($user)->post('/builder/save', $data);
}

it('noraida build bez nosaukuma', function () {
    postBuild([
        'name' => '',
        'products' => [
            'cpu' => [['id' => 1, 'count' => 1]],
        ],
    ])->assertSessionHasErrors('name');
});

it('noraida build ar pārāk garu nosaukumu', function () {
    postBuild([
        'name' => str_repeat('a', 256),
        'products' => [
            'cpu' => [['id' => 1, 'count' => 1]],
        ],
    ])->assertSessionHasErrors('name');
});

it('noraida build bez produktiem', function () {
    postBuild([
        'name' => 'Tukšs dators',
        'products' => [],
    ])->assertSessionHasErrors('products');
});

it('noraida produktu ar count 0', function () {
    postBuild([
        'name' => 'Dators',
        'products' => [
            'cpu' => [['id' => 1, 'count' => 0]],
        ],
    ])->assertSessionHasErrors('products.cpu.0.count');
});

it('noraida produktu ar negatīvu count', function () {
    postBuild([
        'name' => 'Dators',
        'products' => [
            'cpu' => [['id' => 1, 'count' => -1]],
        ],
    ])->assertSessionHasErrors('products.cpu.0.count');
});
