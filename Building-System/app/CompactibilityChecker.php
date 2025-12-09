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

    public function reviewBuild(){
        $errors = $this->validateBuild();
        return null;
    }
    public function validateBuild(){
        $errors = [];
        foreach ($this->build->getItems() as $type => $item){
            // \Log::debug($type);
            if(!isset(self::$rules[$type])){
                continue;
            }
            
            foreach(self::$rules[$type] as $rule){
                // ['requires' => 'mobo', 'field' => 'socket', 'match_field' => 'socket'],
                $requiredType= $rule["requires"];
                if(!$this->build->hasItem($requiredType)){
                    continue;
                }
                $requiredValue = $this->build->getField($requiredType, $rule['match_field']);
                $currentValue = $item['spec'][$rule['field']];
                if(!($requiredValue === $currentValue)){
                    // \Log::info("There is an error");
                    $errors[] = [
                        'component' => $type,
                        'component_name' => $this->build->getProduct($type)['name'],
                        'incompatible_with' => $requiredType,
                        'incompatible_name' => $this->build->getProduct($requiredType)['name'],
                        'message' => "There are error",
                    ];
                }
            }
        }
        \Log::debug($errors);
        return $errors;
    }
}
