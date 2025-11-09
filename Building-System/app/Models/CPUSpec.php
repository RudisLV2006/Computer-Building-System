<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class CPUSpec extends Model
{
    /** @use HasFactory<\Database\Factories\CPUSpecsFactory> */
    use HasFactory;
    
    protected $primaryKey = 'product_id';
    public $incrementing = false;
    protected $table = 'cpu_specs';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
