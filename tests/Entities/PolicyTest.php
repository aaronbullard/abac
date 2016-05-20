<?php 

namespace ABAC\Entities;

use ABAC\Services\Request;
use ABAC\Entities\Operators\Equals;
use ABAC\Entities\Operators\NotEquals;

use Mockery;

class PolicyTest extends \TestCase {
    
    protected $request;
    
    public function setUp()
    {
        parent::setUp();
        $user           = new User;
        $user->name     = 'Aaron';
        $user->gender   = 'Male';
        $this->request  = new Request('GET', 'programs', $user, new Environment);
    }
    
    
    protected function createRule(Request $request, $bool)
    {
        $mock = Mockery::mock(Rule::class);
        $mock->shouldReceive( 'validate' )->with($request)->andReturn($bool);
        return $mock;
    }
    
    
    public function test_ACCEPT_passes()
    {
        $rules = [];
        $rules[] = $this->createRule($this->request, TRUE);
        $rules[] = $this->createRule($this->request, TRUE);
        $rules[] = $this->createRule($this->request, TRUE);
        
        $policy = Policy::create(Policy::ACCEPT, 'Aaron\'s Only', "Only accept Aaron.", $rules);
        
        $this->assertTrue( $policy->validate($this->request) );
    }
    
    
    public function test_ACCEPT_fails_for_one()
    {
        $rules = [];
        $rules[] = $this->createRule($this->request, TRUE);
        $rules[] = $this->createRule($this->request, TRUE);
        $rules[] = $this->createRule($this->request, FALSE);
        
        $policy = Policy::create(Policy::ACCEPT, 'Aaron\'s Only', "Only accept Aaron.", $rules);
        
        $this->assertFalse( $policy->validate($this->request) );
    }
    
    
    public function test_ACCEPT_fails_for_all()
    {
        $rules = [];
        $rules[] = $this->createRule($this->request, FALSE);
        $rules[] = $this->createRule($this->request, FALSE);
        $rules[] = $this->createRule($this->request, FALSE);
        
        $policy = Policy::create(Policy::ACCEPT, 'Aaron\'s Only', "Only accept Aaron.", $rules);
        
        $this->assertFalse( $policy->validate($this->request) );
    }

    
}