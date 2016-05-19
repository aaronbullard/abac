<?php

namespace ABAC\Entities\Operators;

abstract class Operator {
    
    abstract public function execute($leftValue, $rightValue);
}