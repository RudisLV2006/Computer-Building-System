<?php

namespace App\Models\Rules;

interface ValidationRule
{
    public function validate(): array;
}
