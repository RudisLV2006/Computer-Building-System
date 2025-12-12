<?php
use App\CompactibilityChecker;
use App\Models\CPUSpec;
use App\Models\MotherBoardSpec;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Build;

uses(Tests\TestCase::class, RefreshDatabase::class);


it('can get compactible products', function () {
    $type = 'mobo';
    CPUSpec::factory()->create();
    $build = new Build(null);
    $build->addItem("cpu",CPUSpec::first()->product_id);
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
