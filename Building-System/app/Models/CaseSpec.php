<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaseSpec extends Model
{
    use HasFactory;
    protected $primaryKey = 'product_id';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
