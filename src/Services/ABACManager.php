<?php

namespace ABAC\Services;

use InvalidArgumentException;
use ABAC\Entities\Policy;

class ABACManager implements \ABAC\Contracts\Validatable {
    
    protected $acceptPolicies = [];
    
    protected $denyPolicies = [];
    
    
    protected function __construct(array $policies)
    {
        $this->acceptPolicies = static::filterPoliciesByResponseType($policies, Policy::ACCEPT);
   
        $this->denyPolicies = static::filterPoliciesByResponseType($policies, Policy::DENY);
        
        $count = count($this->acceptPolicies) + count($this->denyPolicies);
        
        if(count($policies) > $count){
            throw new InvalidArgumentException("Policy response type is not recognized!");
        }
    }
    
    
    protected static function filterPoliciesByResponseType(array $policies, $responseType)
    {
        return array_filter($policies, function($policy) use ($responseType) {
            return $policy->getResponseType() === $responseType;
        });
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
    
    
    protected function doesADenyPolicyPreventAccess(Request $request)
    {
        foreach($this->denyPolicies as $policy)
        {
            if($policy->validate($request)){
                return TRUE;
            }
        }
        
        return FALSE;
    }
   
    
    protected function doesOneAcceptPolicyGiveAccess(Request $request)
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