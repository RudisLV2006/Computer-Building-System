<?php


return [

    'categories' => [
        'cpu'        => App\Models\CpuSpec::class,
        'cpu-cooler' => App\Models\CpuCoolerSpec::class,
        'motherboard' => App\Models\MotherBoardSpec::class,
        'ram'        => App\Models\RamSpec::class,
        'gpu'        => App\Models\GpuSpec::class,
        'storage'    => App\Models\StorageSpec::class,
        'psu'        => App\Models\PsuSpec::class,
        'case'       => App\Models\CaseSpec::class,
    ],

    'multiple_allowed' => ['ram', 'storage'],

    'case_support_form_factors' => [
        'ATX Mid Tower'  => ['ATX', 'mATX', 'Mini-ITX'],
        'ATX Full Tower' => ['ATX', 'mATX', 'Mini-ITX', 'E-ATX'],
        'mATX Mid Tower' => ['mATX', 'Mini-ITX'],
        'ITX Desktop'    => ['Mini-ITX'],
        'ITX Tower'      => ['Mini-ITX'],
    ],
];
