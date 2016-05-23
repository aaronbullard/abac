<?php

namespace ABAC\Services;

use InvalidArgumentException;
use ABAC\Entities\Policy;

class ABACManager implements \ABAC\Contracts\Validatable {
    
    
    protected $acceptPolicies = [];
    
    protected $denyPolicies = [];
    
    
    private function __construct(array $policies)
    {
        foreach($policies as $policy)
        {
            if($policy->getResponseType() === Policy::ACCEPT){
                $this->acceptPolicies[] = $policy;
                continue;
            }
            
            if($policy->getResponseType() === Policy::DENY){
                $this->denyPolicies[] = $policy;
                continue;
            }
            
            throw new InvalidArgumentException("Policy response type is not recognized!");
        }
    }
    
    
    public static function create(array $policies)
    {
        return new static($policies);
    }
    
    
    public function validate(Request $request)
    {
        // Validate Deny Policies
        if( $this->doesADenyPolicyPreventAccess($request) ){
            return FALSE;  // a DENY policy resolved to true, there access denied
        }
        
        // Validate Accept Policies
        return $this->doesOneAcceptPolicyGiveAccess($request);
    }
    
    
    public function doesADenyPolicyPreventAccess(Request $request)
    {
        foreach($this->denyPolicies as $policy)
        {
            if($policy->validate($request)){
                return TRUE;
            }
        }
        
        return FALSE;
    }
   
    
    public function doesOneAcceptPolicyGiveAccess(Request $request)
    {
        foreach($this->acceptPolicies as $policy)
        {
            if($policy->validate($request)){
                return TRUE;
            }
        }
        
        return FALSE;
    }
}