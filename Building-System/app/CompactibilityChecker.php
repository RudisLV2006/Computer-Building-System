<?php

namespace App;

class CompactibilityChecker
{
    protected $build;
    protected static $rules = [
        'cpu' => [
            ['requires' => 'mobo', 'field' => 'socket', 'match_field' => 'socket'],
        ],
        'mobo' => [
            ['requires' => 'cpu', 'field' => 'socket', 'match_field' => 'socket'],
        ],
    ];
    public function __construct(Build $build)
    {
        $this->build = $build;
    }
    public function getCompactibleProduct($type, $query){
        if(!isset(self::$rules[$type])){
            return $query;
        }
        foreach(self::$rules[$type] as $rule){
            if(!$this->build->hasItem($rule['requires'])){
                continue;
            }

            $requiredValue = $this->build->getField($rule['requires'], $rule['match_field']);
            $operator = $rule['operator'] ?? '=';

            $query->where($rule['field'], $operator, $requiredValue);
        }
        return $query;
    }
}
