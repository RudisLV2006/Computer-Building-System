<?php

namespace App;

use App\Models\MotherboardSpec;
use App\Models\CpuSpec;
use App\Models\RamSpec;

// Speciāla klase ar kuras palīdzību iegūst katra komponenta modeli, kur pēc tam izmanto, lai iegūt datus
class ProductTypeRegistry
{
    public static function exists(string $category): bool
    {
        return isset(config('builder.categories')[$category]);
    }
    public static function all()
    {
        return array_keys(config('builder.categories'));
    }
    public static function isMultiple(string $category)
    {
        return in_array($category, config('builder.multiple_allowed'));
    }
}
