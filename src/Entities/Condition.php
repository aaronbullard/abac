<?php

namespace ABAC\Entities;

use ABAC\Services\Request;
use ABAC\Entities\Operators\Operator;

class Condition implements \ABAC\Contracts\Validatable {
    
    protected $operator;
    
    protected $left;
    
    protected $right;
    
    public function __construct($left, Operator $operator, $right)
    {
        $this->left     = $left;
        $this->operator = $operator;
        $this->right    = $right;
    }
    
    public function validate(Request $request)
    {
        $leftValue  = $request->getValue($this->left);
        $rightValue = $request->getValue($this->right);
        
        return $this->operator->execute($leftValue, $rightValue);
    }
}