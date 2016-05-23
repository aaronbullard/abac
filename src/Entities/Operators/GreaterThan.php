<?php

namespace ABAC\Entities\Operators;

class GreaterThan extends Operator {
    
    public function execute($leftValue, $rightValue)
    {
        return $leftValue > $rightValue;
    }
}