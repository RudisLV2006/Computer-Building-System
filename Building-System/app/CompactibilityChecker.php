<?php

namespace App;

use App\Models\Rules\FilterRule;
use App\Models\Rules\SocketRule as RulesSocketRule;

class CompactibilityChecker
{
    private array $rules = [];

    public function __construct(Build $build)
    {
        $this->rules = [
            new RulesSocketRule($build),
        ];
    }

    public function getCompactibleProduct($category, $query)
    {

        foreach ($this->rules as $rule) {
            \Log::debug(class_parents($rule, true));
            \Log::debug(class_implements($rule, true));
            if ($rule instanceof FilterRule && $rule->appliesTo($category)) {
                $rule->apply($query, $category);
            }
        }
        return $query;
    }
}
