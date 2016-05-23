<?php 

namespace ABAC\Entities;

use ABAC\Services\Request;
use ABAC\Entities\Operators\Equals;
use ABAC\Entities\Operators\NotEquals;

class RuleTest extends \TestCase {
    
    protected $request;
    
    public function setUp()
    {
        parent::setUp();
        $user           = new User;
        $user->name     = 'Aaron';
        $user->gender   = 'Male';
        $this->request  = new Request('GET', 'programs', $user, new Environment);
    }
    
    
    public function test_it_passes()
    {
        $conditions = [];
        
        $conditions[] = new Condition("$.user.name", new Equals, "Aaron");
        $conditions[] = new Condition("$.user.gender", new Equals, "Male");
        
        $rule = new Rule("Aaron's Rule", "Is an Aaron", $conditions);
        
        $this->assertTrue( $rule->validate($this->request) );
    }
    
    
    public function test_it_fails()
    {
        $conditions = [];
        
        $conditions[] = new Condition("$.user.name", new Equals, "Bob");
        $conditions[] = new Condition("$.user.gender", new Equals, "Male");
        
        $rule = new Rule("Bob's Rule", "Is an Bob", $conditions);
        
        $this->assertFalse( $rule->validate($this->request) );
    }
    
    
    public function test_it_passes_as_OR_conditions()
    {
        $conditions = [];
        
        $conditions[] = new Condition("$.user.name", new Equals, "Bob");
        $conditions[] = new Condition("$.user.gender", new Equals, "Male");
        
        $rule = new Rule("Bob's Rule", "Is a Bob", $conditions, TRUE);
        
        $this->assertTrue( $rule->validate($this->request) );
    }
    

}