<?php

namespace App\Models\Rules;

use App\Models\Rules\BaseRule;
use App\Models\Rules\ValidationRule;
use Override;

class GpuRule extends BaseRule implements ValidationRule
{
    #[Override]
    public function validate(): array
    {
        $errors = [];

        if ($this->build->hasItem('gpu') && $this->build->hasItem('motherboard')) {
            $gpuPcie  = $this->build->getField('gpu', 'pcie_version');
            $moboPcie = $this->build->getField('motherboard', 'pcie_version');

            if ($gpuPcie > $moboPcie) {
                $errors[] = "GPU PCIe version ({$gpuPcie}) is not compatible with motherboard PCIe version ({$moboPcie}).";
            }
        }

        return $errors;
    }
}
