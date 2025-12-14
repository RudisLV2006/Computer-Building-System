<?php

namespace App;

use App\Models\MotherboardSpec;
use App\Models\CpuSpec;
use App\Models\RamSpec;

// Speciāla klase ar kuras palīdzību iegūst katra komponenta modeli, kur pēc tam izmanto, lai iegūt datus
class ProductTypeRegistry
{
    protected static array $typeMap = [
        'motherboard' => MotherboardSpec::class,
        'cpu'  => CpuSpec::class,
        'ram' => RamSpec::class,
    ];
    public static function getModel(string $type): ?string
    {
        return self::$typeMap[$type];
    }
    public static function exists(string $type): bool
    {
        return isset(self::$typeMap[$type]);
    }
    public static function returnTypes()
    {
        return array_keys(self::$typeMap);
    }
}
