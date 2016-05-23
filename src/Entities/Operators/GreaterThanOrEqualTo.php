<?php

namespace ABAC\Entities\Operators;

class GreaterThanOrEqualTo extends Operator {
    
    public function execute($leftValue, $rightValue)
    {
        return $leftValue >= $rightValue;
    }
}