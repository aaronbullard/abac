<?php

namespace ABAC\Entities\Operators;

use InvalidArgumentException;

class BetweenTest extends OperatorTest{

    public function test_true()
    {
        $this->assertTrue( $this->operator->execute(2, [1,3]) );
    }
    
    public function test_false()
    {
        $this->assertFalse( $this->operator->execute(4, [1,3]) );
        $this->assertFalse( $this->operator->execute(1, [1,3]) );
        $this->assertFalse( $this->operator->execute(3, [1,3]) );
    }
    
    public function test_exception_for_second_arg()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        $this->operator->execute(1, 2);
    }
}