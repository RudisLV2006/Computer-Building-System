<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Builds extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'isComplete',
    ];
    public function items()
    {
        return $this->hasMany(BuildItem::class, "build_id");
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
