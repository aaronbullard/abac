<?php

namespace ABAC\Services;

use InvalidArgumentException;
use ABAC\Entities\User;
use ABAC\Entities\Environment;

class RequestTest extends \TestCase {
    
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function test_it_get_value()
    {
        $user = new User;
        $user->name = 'Aaron';
        
        $request = new Request('GET', 'programs', $user, new Environment);
       
        $this->assertEquals($user->name, $request->getValue('$.user.name'));
    }
    
    public function test_it_throws_an_invalidargumentexception()
    {
        $user = new User;
        $user->name = 'Aaron';
        
        $request = new Request('GET', 'programs', $user, new Environment);
       
        $this->setExpectedException(InvalidArgumentException::class, "Property 'age' does not exist!");
       
        $request->getValue('$.user.age');
    }
}