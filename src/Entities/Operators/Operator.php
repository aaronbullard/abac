<?php

namespace ABAC\Entities\Operators;

abstract class Operator {
    
    // public function __construct($left, $right)
    // {
    //     return $this->execute($left, $right);
    // }
    
    abstract public function execute($leftValue, $rightValue);
}