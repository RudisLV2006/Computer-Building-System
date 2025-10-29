<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\MotherBoardFactory;

class MotherBoardSpec extends Model
{
    use HasFactory;

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }

    protected static function newFactory(): MotherBoardFactory
    {
        return MotherBoardFactory::new();
    }
    //
}
