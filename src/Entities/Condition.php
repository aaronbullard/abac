<?php

namespace ABAC\Entities;

use ABAC\Services\Request;

class Condition implements \ABAC\Contracts\Validatable {
    
    protected $operator;
    
    protected $left;
    
    protected $right;
    
    public function __construct(Operator $operator, $left, $right)
    {
        $this->operator = $operator;
        $this->left = $left;
        $this->right = $right;
    }
    
    public function validate(Request $request)
    {
        $leftValue = $request->getValue($this->left);
        $rightValue = $request->getValue($this->right);
        
        return $this->operator->execute($leftValue, $rightValue);
    }
}