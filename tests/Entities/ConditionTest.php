<?php 

namespace ABAC\Entities;

use ABAC\Services\Request;
use ABAC\Entities\Operators\Equals;
use ABAC\Entities\Operators\NotEquals;

class ConditionTest extends \TestCase {
    
    protected $request;
    
    public function setUp()
    {
        parent::setUp();
        $user           = new User;
        $user->name     = 'Aaron';
        $this->request  = new Request('GET', 'programs', $user, new Environment);
    }
    
    
    public function test_it_validates_equals()
    {
        $condition = new Condition("$.user.name", new Equals, "Aaron");
        $this->assertTrue( $condition->validate($this->request) );
        
        $condition = new Condition("$.user.name", new Equals, "Bob");
        $this->assertFalse( $condition->validate($this->request) );
    }
    
    
    public function test_it_validates_not_equals()
    {
        $condition = new Condition("$.user.name", new NotEquals, "Aaron");
        $this->assertFalse( $condition->validate($this->request) );
        
        $condition = new Condition("$.user.name", new NotEquals, "Bob");
        $this->assertTrue( $condition->validate($this->request) );
    }
}