<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CpuCoolerSpec extends Model
{
    use HasFactory;
    protected $primaryKey = 'product_id';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function sockets()
    {
        return $this->hasMany(CoolerSocket::class, 'cooler_id');
    }
}
