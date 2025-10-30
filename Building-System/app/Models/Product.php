<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\MotherBoardSpec;

class Product extends Model
{
    use HasFactory;

    public function motherBoard(): HasOne
    {
        return $this->hasOne(MotherBoardSpec::class);
    }
   
}
