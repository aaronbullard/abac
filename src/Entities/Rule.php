<?php

namespace ABAC\Entities;

class Rule implements \ABAC\Contracts\Validatable {
    
    
    protected $name;
    
    protected $description;
    
    protected $conditions;
    
    public function __construct($name, $description, array $conditions)
    {
        $this->name = $name;
        $this->description = $description;
        $this->conditions = $conditions;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    
    public function getDescription()
    {
        return $this->description;
    }
    
    
    public function validate(Request $request)
    {
        foreach($this->conditions as $rule){
            if( ! $rule->validate($request)){
                return FALSE;
            }
        }
        
        return TRUE;
    }
}