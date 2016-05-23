<?php

namespace ABAC\Services;

use InvalidArgumentException;
use ABAC\Entities\User;
use ABAC\Entities\Environment;


class Request {
    
    protected $action;
    
    protected $resource;
    
    protected $user;
    
    protected $environment;
    
    
    public function __construct($action, $resource, User $user, Environment $env)
    {
        $this->action = $action;
        $this->resource = $ressource;
        $this->user = $user;
        $this->environment = $env;
    }
    
    
    public function getValue($value)
    {
        $params = explode(".", $value);
        
        // is value NOT a dot notation starting with $.
        if( $params[0] === "$" ){
            array_shift($params);  
        }
        else{
            return $params[0];
        }
        
        
        return array_reduce($params, function($carry, $item){
            
            // Check property is set
            if(property_exists($carry, $item)){
                return $carry->{$item};
            }
            
            throw new InvalidArgumentException("Property '$item' does not exist!");
            
        }, $this);
    }
}