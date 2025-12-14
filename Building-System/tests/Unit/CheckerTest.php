<?php

use App\CompactibilityChecker;
use App\Models\CPUSpec;
use App\Models\MotherBoardSpec;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Build;

uses(Tests\TestCase::class, RefreshDatabase::class);


it('can get compactible products', function () {
    $type = 'motherboard';
    CPUSpec::factory()->create();
    $build = new Build(null);
    $build->addItem("cpu", CPUSpec::first()->product_id);
    $checker = new CompactibilityChecker($build);

    $query = MotherBoardSpec::with('product');

    $query = $checker->getCompactibleProduct($type, $query);
    // dd($query->toSql());

    expect($query->toSql())
        ->toContain('where "socket" = ?');
    // dd($query->getBindings());
    expect($query->getBindings())
        ->toHaveCount(1);
});

it('can return error message with wrong selected parts', function () {
    $cpu = CPUSpec::factory()->create(["socket" => "LGA1700"]);
    $mobo = MotherBoardSpec::factory()->create(["socket" => "AM5"]);
    $build = new Build(null);

    $build->addItem("cpu", $cpu->product_id);
    $build->addItem("motherboard", $mobo->product_id);

    $checker = new CompactibilityChecker($build);
    $pairKey = $checker->createKeyPairs("cpu", "motherboard", "socket", "socket");
    $result = $checker->validateBuild();

    expect($result)->toBeArray()->not()->toBeEmpty();
    expect($result)->toHaveKey($pairKey);
});

it('can return error empty message with right selected parts', function () {
    $cpu = CPUSpec::factory()->create(["socket" => "LGA1700"]);
    $mobo = MotherBoardSpec::factory()->create(["socket" => "LGA1700"]);
    $build = new Build(null);

    $build->addItem("cpu", $cpu->product_id);
    $build->addItem("mobo", $mobo->product_id);

    $checker = new CompactibilityChecker($build);
    $pairKey = $checker->createKeyPairs("cpu", "mobo", "socket", "socket");
    $result = $checker->validateBuild();

    expect($result)->toBeArray()->toBeEmpty();
});
