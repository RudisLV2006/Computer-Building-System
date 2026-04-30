<?php


return [

    'categories' => [
        'cpu'        => App\Models\CpuSpec::class,
        'motherboard' => App\Models\MotherBoardSpec::class,
        'ram'        => App\Models\RamSpec::class,
        // 'gpu'        => App\Models\GpuSpec::class,
        // 'storage'    => App\Models\StorageSpec::class,
        // 'psu'        => App\Models\PsuSpec::class,
        // 'case'       => App\Models\PcCaseSpec::class,
        // 'cpu_cooler' => App\Models\CpuCoolerSpec::class,
    ],

    'multiple_allowed' => ['ram', 'storage'],

    'relation' => [
        // CPU ↔ Motherboard
        [
            'from_type' => 'cpu',
            'to_type' => 'motherboard',
            'from_field' => 'socket',
            'to_field' => 'socket',
            'operator' => '='
        ],
        // Motherboard ↔ RAM
        [
            'from_type' => 'motherboard',
            'to_type' => 'ram',
            'from_field' => 'memory_technology',
            'to_field' => 'memory_type',
            'operator' => '='
        ],
        // Motherboard ↔ RAM slots (max ram count)
        [
            'from_type' => 'motherboard',
            'to_type' => 'ram',
            'from_field' => 'memory_slots',
            'to_field' => 'count', // build count, nevis modelis
            'operator' => '>='
        ],
        // CPU ↔ RAM (max supported memory speed)
        [
            'from_type' => 'cpu',
            'to_type' => 'ram',
            'from_field' => 'max_memory_speed',
            'to_field' => 'speed',
            'operator' => '>='
        ],
        // GPU ↔ Motherboard (PCIe versija)
        [
            'from_type' => 'gpu',
            'to_type' => 'motherboard',
            'from_field' => 'pcie_version',
            'to_field' => 'pcie_version',
            'operator' => '<='
        ],
        // Storage ↔ Motherboard (M.2 vai SATA)
        [
            'from_type' => 'storage',
            'to_type' => 'motherboard',
            'from_field' => 'interface',
            'to_field' => 'storage_interface',
            'operator' => '='
        ],
        // CPU Cooler ↔ CPU (TDP)
        [
            'from_type' => 'cpu_cooler',
            'to_type' => 'cpu',
            'from_field' => 'max_tdp',
            'to_field' => 'tdp',
            'operator' => '>='
        ],
        // CPU Cooler ↔ Motherboard (socket saderība)
        [
            'from_type' => 'cpu_cooler',
            'to_type' => 'motherboard',
            'from_field' => 'socket',
            'to_field' => 'socket',
            'operator' => '='
        ],
        // PSU ↔ GPU (wattage)
        [
            'from_type' => 'psu',
            'to_type' => 'gpu',
            'from_field' => 'wattage',
            'to_field' => 'required_wattage',
            'operator' => '>='
        ],
        // Case ↔ Motherboard (form factor)
        [
            'from_type' => 'case',
            'to_type' => 'motherboard',
            'from_field' => 'form_factor',
            'to_field' => 'form_factor',
            'operator' => '='
        ],
        // Case ↔ GPU (max gpu length)
        [
            'from_type' => 'case',
            'to_type' => 'gpu',
            'from_field' => 'max_gpu_length',
            'to_field' => 'length',
            'operator' => '>='
        ],
        // Case ↔ CPU Cooler (max cooler height)
        [
            'from_type' => 'case',
            'to_type' => 'cpu_cooler',
            'from_field' => 'max_cooler_height',
            'to_field' => 'height',
            'operator' => '>='
        ],
        // RAM ↔ RAM (savstarpējā saderība)
        [
            'from_type' => 'ram',
            'to_type' => 'ram',
            'from_field' => 'memory_type',
            'to_field' => 'memory_type',
            'operator' => '='
        ],
    ],
];
