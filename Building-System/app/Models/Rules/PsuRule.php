<?php

namespace App\Models\Rules;

use App\Models\Rules\BaseRule;
use App\Models\Rules\ValidationRule;
use Override;

class PsuRule extends BaseRule implements ValidationRule
{
    #[Override]
    public function validate(): array
    {
        if (!$this->build->hasItem('psu')) {
            return [];
        }

        $psuWattage = $this->build->getField('psu', 'wattage_w');
        $totalWattage = 0;

        if ($this->build->hasItem('cpu')) {
            $totalWattage += $this->build->getField('cpu', 'wattage_w');
        }

        if ($this->build->hasItem('gpu')) {
            $totalWattage += $this->build->getField('gpu', 'wattage_w');
        }

        if ($totalWattage === 0) {
            return [];
        }

        if ($psuWattage < $totalWattage) {
            return ["PSU is too weak — system requires {$totalWattage}W but PSU only provides {$psuWattage}W."];
        }

        return [];
    }
}
