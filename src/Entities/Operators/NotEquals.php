<?php

namespace ABAC\Entities\Operators;

class NotEquals extends Operator {
    
    public function execute($leftValue, $rightValue)
    {
        return $leftValue !== $rightValue;
    }
}