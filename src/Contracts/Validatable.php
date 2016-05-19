<?php

namespace ABAC\Contracts;

use ABAC\Services\Request;

interface Validatable {
    
    /**
     * 
     * @param   ABAC\Services\Request
     * @returns Boolean
     */
    public function validate(Request $request);
}