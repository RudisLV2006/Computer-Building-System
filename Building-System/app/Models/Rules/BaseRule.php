<?php

namespace App\Models\Rules;

use App\Build;

abstract class BaseRule
{
    public function __construct(protected Build $build) {}
}
