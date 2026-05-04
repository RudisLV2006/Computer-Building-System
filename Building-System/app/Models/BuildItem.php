<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BuildItem extends Model
{
    protected $fillable = [
        'category',
        'product_id',
        'count'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
