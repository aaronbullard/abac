<?php

namespace ABAC\Entities\Operators;

abstract class OperatorTest extends \TestCase{

    protected $operator;
    
    public function setUp()
    {
        parent::setUp();
        $class = str_replace("Test", "", get_class($this));
        $this->operator = new $class;
    }
    
}