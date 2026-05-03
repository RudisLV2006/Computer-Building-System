<?php

namespace App\Models\Rules;

use Illuminate\Database\Eloquent\Builder;

interface FilterRule
{
    public function appliesTo(string $category): bool;
    public function apply(Builder $query, string $category): void;
}
