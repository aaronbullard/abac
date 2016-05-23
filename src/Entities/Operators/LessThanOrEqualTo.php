<?php

namespace ABAC\Entities\Operators;

class LessThanOrEqualTo extends Operator {
    
    public function execute($leftValue, $rightValue)
    {
        return $leftValue <= $rightValue;
    }
}