<?php

namespace ABAC\Services;

use Mockery;
use ABAC\Entities\Policy;
use ABAC\Entities\User;
use ABAC\Entities\Environment;

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
        $mock->shouldReceive('validate')->with($request)->once()->andReturn($bool);
        $mock->shouldReceive('getResponseType')->once()->andReturn($responseType);
        
        return $mock;
    }
    
    
    public function test_it_passes_ACCEPT_policies()
    {
        $policies = [];
    }
}