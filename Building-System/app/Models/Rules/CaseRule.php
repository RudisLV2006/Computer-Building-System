<?php

namespace App\Models\Rules;

use App\Models\Rules\BaseRule;
use App\Models\Rules\FilterRule;
use Illuminate\Database\Eloquent\Builder;
use Override;

class CaseRule extends BaseRule implements FilterRule, ValidationRule
{
    #[Override]
    public function appliesTo(string $category): bool
    {
        return in_array($category, ['case', 'motherboard', 'gpu', 'cpu-cooler']);
    }
    #[Override]
    public function apply(Builder $query, string $category): void
    {
        match ($category) {
            'case'        => $this->filterCase($query),
            'motherboard' => $this->filterMotherboard($query),
            'gpu'         => $this->filterGpu($query),
            'cpu-cooler'  => $this->filterCooler($query),
        };
    }

    private function filterCase(Builder $query): void
    {
        if ($this->build->hasItem('motherboard')) {
            $formFactor = $this->build->getField('motherboard', 'form_factor');
            $configMap  = config('builder.case_support_form_factors');
            $allowed    = array_keys(array_filter($configMap, fn($f) => in_array($formFactor, $f)));
            $query->whereIn('case_type', $allowed);
        }

        if ($this->build->hasItem('gpu')) {
            $length = $this->build->getField('gpu', 'length');
            $query->where('max_gpu_length', '>=', $length);
        }

        if ($this->build->hasItem('cpu-cooler')) {
            $height = $this->build->getField('cpu-cooler', 'height_mm');
            $query->where('max_cooler_height_mm', '>=', $height);
        }
    }

    private function filterMotherboard(Builder $query): void
    {
        if ($this->build->hasItem('case')) {
            $caseType  = $this->build->getField('case', 'case_type');
            $configMap = config('builder.case_support_form_factors');
            $allowed   = $configMap[$caseType] ?? [];
            $query->whereIn('form_factor', $allowed);
        }
    }

    private function filterGpu(Builder $query): void
    {
        if ($this->build->hasItem('case')) {
            $maxLength = $this->build->getField('case', 'max_gpu_length_mm');
            $query->where('length', '<=', $maxLength);
        }
    }

    private function filterCooler(Builder $query): void
    {
        if ($this->build->hasItem('case')) {
            $maxHeight = $this->build->getField('case', 'max_cooler_height_mm');
            $query->where('height_mm', '<=', $maxHeight);
        }
    }
    #[Override]
    public function validate(): array
    {
        $errors = [];

        if ($this->build->hasItem('case') && $this->build->hasItem('motherboard')) {
            $caseType   = $this->build->getField('case', 'case_type');
            $formFactor = $this->build->getField('motherboard', 'form_factor');
            $configMap  = config('builder.case_support_form_factors');
            $allowed    = $configMap[$caseType] ?? [];

            if (!in_array($formFactor, $allowed)) {
                $errors[] = "Case ({$caseType}) does not support motherboard form factor ({$formFactor}).";
            }
        }

        if ($this->build->hasItem('case') && $this->build->hasItem('gpu')) {
            $maxLength = $this->build->getField('case', 'max_gpu_length_mm');
            $gpuLength = $this->build->getField('gpu', 'length');

            if ($gpuLength > $maxLength) {
                $errors[] = "GPU is too long ({$gpuLength}mm) — case only supports up to {$maxLength}mm.";
            }
        }

        if ($this->build->hasItem('case') && $this->build->hasItem('cpu-cooler')) {
            $maxHeight    = $this->build->getField('case', 'max_cooler_height_mm');
            $coolerHeight = $this->build->getField('cpu-cooler', 'height_mm');

            if ($coolerHeight > $maxHeight) {
                $errors[] = "CPU cooler is too tall ({$coolerHeight}mm) — case only supports up to {$maxHeight}mm.";
            }
        }

        return $errors;
    }
}
