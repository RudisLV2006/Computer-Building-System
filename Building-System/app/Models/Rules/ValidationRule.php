<?php

namespace App\Models\Rules;

interface ValidationRule
{
    public function appliesTo(string $category): bool;
    public function validate(string $category): array;
}
