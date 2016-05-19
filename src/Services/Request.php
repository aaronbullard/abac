<?php

namespace ABAC\Services;

class Request {
    
    protected $action;
    
    protected $resource;
    
    protected $user;
    
    protected $environment;
    
    public function _construct($action, $resource, User $user, Environment $env)
    {
        $this->action = $action;
        $this->resource = $ressource;
        $this->user = $user;
        $this->environment = $env;
    }
    
    public function getValue($dotNotation)
    {
        // TODO: Parse dot notation to find requested values
    }
}