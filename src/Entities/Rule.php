<?php

namespace ABAC\Entities;

use ABAC\Services\Request;
use ABAC\Traits\DescriptionTrait;

class Rule implements \ABAC\Contracts\Validatable {
    
    use DescriptionTrait;

    protected $conditions;
    
    protected $isORRule;
    
    public function __construct($name, $description, array $conditions, $isORRule = FALSE)
    {
        $this->name = $name;
        $this->description = $description;
        $this->conditions = $conditions;
        $this->isORRule = $isORRule;
    }
    

    public function validate(Request $request)
    {
        return $this->isORRule ? $this->validateAsOR($request) : $this->validateAsAND($request);
    }
    
    
    protected function validateAsAND(Request $request)
    {
        // If one condition doesn't pass, return FALSE
        foreach($this->conditions as $condition){
            if(! $condition->validate($request)){
                return FALSE;
            }
        }
        
        return TRUE;
    }
    
    protected function validateAsOR(Request $request)
    {
        // If one condition passes, return TRUE
        foreach($this->conditions as $condition){
            if($condition->validate($request)){
                return TRUE;
            }
        }
        
        return FALSE;
    }
}