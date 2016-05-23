<?php

namespace ABAC\Entities\Operators;

class LessThanOrEqualToTest extends OperatorTest{

    public function test_true()
    {
        $this->assertTrue( $this->operator->execute(1, 2) );
        $this->assertTrue( $this->operator->execute(2, 2) );
    }
    
    public function test_false()
    {
        $this->assertFalse( $this->operator->execute(2, 1) );
    }
}