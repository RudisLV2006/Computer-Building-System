<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;

class MotherboardSpec extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
