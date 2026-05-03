<?php

namespace App\Models\Rules;

use App\Models\Rules\BaseRule;
use App\Models\Rules\FilterRule;
use App\Models\Rules\ValidationRule;
use Illuminate\Database\Eloquent\Builder;
use Override;

class RamTypeRule extends BaseRule implements FilterRule, ValidationRule
{
    #[Override]
    public function appliesTo(string $category): bool
    {
        return in_array($category, ['ram', 'motherboard']);
    }
    #[Override]
    public function apply(Builder $query, string $category): void
    {
        match ($category) {
            'ram'         => $this->filterRam($query),
            'motherboard' => $this->filterMotherboard($query),
        };
    }


    private function filterRam(Builder $query): void
    {
        if ($this->build->hasItem('motherboard')) {
            $type = $this->build->getField('motherboard', 'memory_technology');
            $query->where('memory_type', $type);
            return;
        }
        // match other ram already in build
        if ($this->build->hasItem('ram')) {
            $type = $this->build->getField('ram', 'memory_type');
            $query->where('memory_type', $type);
        }
    }

    private function filterMotherboard(Builder $query): void
    {
        if ($this->build->hasItem('ram')) {
            $type = $this->build->getField('ram', 'memory_type');
            $query->where('memory_technology', $type);
        }
    }
    #[Override]
    public function validate(): array
    {
        $errors = [];

        if ($this->build->hasItem('ram') && $this->build->hasItem('motherboard')) {
            $ramType  = $this->build->getField('ram', 'memory_type');
            $moboType = $this->build->getField('motherboard', 'memory_technology');

            if ($ramType !== $moboType) {
                $errors[] = "RAM type ({$ramType}) does not match motherboard memory technology ({$moboType}).";
            }

            $slots    = $this->build->getField('motherboard', 'memory_slots');
            $ramCount = count($this->build->items['ram']);

            if ($ramCount > $slots) {
                $errors[] = "Too many RAM sticks — motherboard only supports {$slots} slots.";
            }
        }

        if ($this->build->hasItem('ram') && !$this->build->hasItem('motherboard')) {
            // validate ram sticks match each other
            $types = [];
            foreach ($this->build->items['ram'] as $id => $value) {
                $types[] = $this->build->getField('ram', 'memory_type');
            }

            if (count(array_unique($types)) > 1) {
                $errors[] = "All RAM sticks must be the same memory type.";
            }
        }

        return $errors;
    }
}
