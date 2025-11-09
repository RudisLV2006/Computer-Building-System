<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CPUSpecs extends Model
{
    /** @use HasFactory<\Database\Factories\CPUSpecsFactory> */
    use HasFactory;

    protected $table = 'cpu_specs';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
