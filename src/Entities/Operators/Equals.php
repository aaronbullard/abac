<?php

namespace ABAC\Entities\Operators;

class Equals extends Operator {
    
    public function execute($leftValue, $rightValue)
    {
        return $leftValue === $rightValue;
    }
}