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
        $checkedPairs = [];
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

                $pairKey = $this->createKeyPairs($type, $requiredType, $rule['field'], $rule['match_field']);

                if (isset($checkedPairs[$pairKey])) {
                    continue;
                }

                $checkedPairs[$pairKey] = true;

                $requiredValue = $this->build->getField($requiredType, $rule['match_field']);
                $currentValue = $item['spec'][$rule['field']];
                $operator = $rule['operator'] ?? '=';
                if(!$this->checkCompactibility($requiredValue,$currentValue,$operator)){
                    // \Log::info("There is an error");
                    $errors[] = [
                        'component' => $type,
                        'component_name' => $this->build->getProduct($type)['name'],
                        'incompatible_with' => $requiredType,
                        'incompatible_name' => $this->build->getProduct($requiredType)['name'],
                        'field' => $rule['field'],
                        'match_field' => $rule['match_field'],
                        'expected' => $requiredValue,
                        'actual' => $currentValue,
                        'message' => $this->generateErrorMessage(
                            $type,
                            $rule,
                            $requiredValue,
                            $currentValue,
                            $this->build->getProduct($type)['name'],
                            $this->build->getProduct($requiredType)['name']
                        ),
                    ];
                }
            }
        }
        \Log::debug($errors);
        return $errors;
    }
    public function createKeyPairs($type1, $type2, $field1, $field2){
        $component = [$type1,$type2];
        sort($component);

        if($field1===$field2){
            return implode("-", $component) . ":" . $field1;
        }
        return implode("-", $component) . ":" . $field1 . "-" . $field2;
    }
    public function checkCompactibility($currentField, $requiredField,$operator){
        switch($operator){
            case "=":
                return $currentField==$requiredField;
            default:
                return false;
        }
    }
    public function generateErrorMessage($type, $rule, $requiredValue, $currentValue, $componentName, $requiredComponentName){
        $fieldName = ucfirst(str_replace('_', ' ', $rule["field"]));

        return sprintf(
            "%s is incompatible with %s. %s requires %s %s but %s has %s.",
            $componentName,
            $requiredComponentName,
            $requiredComponentName,
            $fieldName,
            $requiredValue,
            $componentName,
            $currentValue
        );
    }
}
