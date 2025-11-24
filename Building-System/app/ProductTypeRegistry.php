<?php

namespace App;

use App\Models\MotherBoardSpec;
use App\Models\CPUSpec;

class ProductTypeRegistry
{
    private static array $typeMap = [
        'mobo' => MotherBoardSpec::class,
        'cpu'  => CPUSpec::class,
    ];
    public static function getModel(string $type): ?string
    {
        return self::$typeMap[$type];
    }
    public static function exists(string $type): bool
    {
        return isset(self::$typeMap[$type]);
    }
}
