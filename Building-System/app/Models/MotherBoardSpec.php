<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\MotherBoardFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;

class MotherBoardSpec extends Model
{
    use HasFactory;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function newFactory(): MotherBoardFactory
    {
        return MotherBoardFactory::new();
    }
    //
}
