<?php

namespace ABAC\Entities\Operators;

class LessThanInclusive extends Operator {
    
    public function execute($leftValue, $rightValue)
    {
        return $leftValue <= $rightValue;
    }
}