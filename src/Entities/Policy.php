<?php

namespace ABAC\Entities;

use InvalidArgumentException;
use ABAC\Services\Request;
use ABAC\Traits\DescriptionTrait;

class Policy implements \ABAC\Contracts\Validatable {
    
    use DescriptionTrait;
    
    const ACCEPT    = 'ACCEPT';
    const DENY      = 'DENY';
    
    protected $responseType;
    
    protected $rules;
    
    
    public function __construct($responseType, $name, $description, array $rules)
    {
        if( ! in_array($responseType, [static::ACCEPT, static::DENY]) ){
            throw new InvalidArgumentException("Response type must be 'ACCEPT' or 'DENY.");
        }
        
        $this->responseType = $responseType;
        $this->name = $name;
        $this->description = $description;
        $this->rules = $rules;
    }
    
    
    public static function create($responseType, $name, $description, array $rules)
    {
        return new static($responseType, $name, $description, $rules);
    }
    
    
    /**
     * Either ACCEPT or DENY
     */
    public function getResponseType()
    {
        return $this->responseType;
    }
    
    
    public function validate(Request $request)
    {
        foreach($this->rules as $rule){
            if( ! $rule->validate($request)){
                return FALSE;
            }
        }
        
        return TRUE;
    }
}