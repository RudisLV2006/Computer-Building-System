<?php

namespace App;

use App\Models\Rules\FilterRule;
use App\Models\Rules\SocketRule as RulesSocketRule;
use App\Models\Rules\RamTypeRule as RulesRamRule;
use App\Models\Rules\CaseRule as RulesCaseRule;
use App\Models\Rules\GpuRule as RulesGpuRule;
use App\Models\Rules\PsuRule as RulesPsuRule;
use App\Models\Rules\ValidationRule;
use Illuminate\Database\Eloquent\Builder;

class CompactibilityChecker
{
    private array $rules = [];

    public function __construct(Build $build)
    {
        $this->rules = [
            new RulesSocketRule($build),
            new RulesRamRule($build),
            new RulesCaseRule($build),
            new RulesGpuRule($build),
            new RulesPsuRule($build),
        ];
    }

    public function filter(string $category, Builder $query)
    {

        foreach ($this->rules as $rule) {
            // \Log::debug(class_parents($rule, true));
            // \Log::debug(class_implements($rule, true));
            if ($rule instanceof FilterRule && $rule->appliesTo($category)) {
                $rule->apply($query, $category);
            }
        }
        return $query;
    }

    public function validate()
    {
        $errors = [];
        foreach ($this->rules as $rule) {
            if ($rule instanceof ValidationRule) {
                $errors = array_merge($errors, $rule->validate());
            }
        }
        return $errors;
    }
}
