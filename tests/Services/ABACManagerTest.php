<?php

namespace ABAC\Services;

use Mockery;
use ABAC\Entities\Policy;
use ABAC\Entities\User;
use ABAC\Entities\Environment;
use InvalidArgumentException;

class ABACManagerTest extends \TestCase {
    
    protected $request;
    
    
    public function setUp()
    {
        parent::setUp();
        $user           = new User;
        $user->name     = 'Aaron';
        $user->gender   = 'Male';
        $this->request  = new Request('GET', 'programs', $user, new Environment);
    }
    
    
    protected static function createPolicy(Request $request, $responseType, $bool)
    {
        $mock = Mockery::mock(Policy::class);
        $mock->shouldReceive('validate')->with($request)->andReturn($bool);
        $mock->shouldReceive('getResponseType')->andReturn($responseType);
        
        return $mock;
    }
    
    
    public function test_it_passes_with_one_ACCEPT_policy()
    {
        $policies = [];
        $policies[] = $this->createPolicy($this->request, Policy::ACCEPT, FALSE);
        $policies[] = $this->createPolicy($this->request, Policy::ACCEPT, FALSE);
        $policies[] = $this->createPolicy($this->request, Policy::ACCEPT, TRUE);
        
        $abac = ABACManager::create($policies);
        
        $this->assertTrue( $abac->validate( $this->request ) );
    }
    
    
    public function test_it_fail_with_no_ACCEPT_policy()
    {
        $policies = [];
        $policies[] = $this->createPolicy($this->request, Policy::ACCEPT, FALSE);
        $policies[] = $this->createPolicy($this->request, Policy::ACCEPT, FALSE);
        $policies[] = $this->createPolicy($this->request, Policy::ACCEPT, FALSE);
        
        $abac = ABACManager::create($policies);
        
        $this->assertFalse( $abac->validate( $this->request ) );
    }
    
    
    public function test_it_fails_with_one_DENY_policy()
    {
        $policies = [];
        $policies[] = $this->createPolicy($this->request, Policy::ACCEPT, FALSE);
        $policies[] = $this->createPolicy($this->request, Policy::ACCEPT, FALSE);
        $policies[] = $this->createPolicy($this->request, Policy::ACCEPT, TRUE);
        $policies[] = $this->createPolicy($this->request, Policy::DENY, TRUE);
        
        $abac = ABACManager::create($policies);
        
        $this->assertFalse( $abac->validate( $this->request ) );
    }
    
    
    public function test_it_passes_with_failed_DENY_policy()
    {
        $policies = [];
        $policies[] = $this->createPolicy($this->request, Policy::ACCEPT, FALSE);
        $policies[] = $this->createPolicy($this->request, Policy::ACCEPT, FALSE);
        $policies[] = $this->createPolicy($this->request, Policy::ACCEPT, TRUE);
        $policies[] = $this->createPolicy($this->request, Policy::DENY, FALSE);
        
        $abac = ABACManager::create($policies);
        
        $this->assertTrue( $abac->validate( $this->request ) );
    }
    
    
    public function test_exception_for_invalid_response_type()
    {
        $policies = [];
        $policies[] = $this->createPolicy($this->request, "NO_SUCH_TYPE", TRUE);
        
        $this->setExpectedException(InvalidArgumentException::class);
        $abac = ABACManager::create($policies);
    }
}