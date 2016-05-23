<?php

namespace ABAC\Entities\Operators;

class BetweenInclusiveTest extends BetweenTest {

    public function test_true()
    {
        $this->assertTrue( $this->operator->execute(2, [1,3]) );
        $this->assertTrue( $this->operator->execute(1, [1,3]) );
        $this->assertTrue( $this->operator->execute(3, [1,3]) );
    }
    
    public function test_false()
    {
        $this->assertFalse( $this->operator->execute(4, [1,3]) );
    }
}