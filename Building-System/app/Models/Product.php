<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\MotherboardSpec;
use App\Models\CpuSpec;

class Product extends Model
{
    use HasFactory;
}
