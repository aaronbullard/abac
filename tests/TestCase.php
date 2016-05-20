<?php 

function dd($value){
    print_r($value);
    print_r("\n");
    exit;
}

class TestCase extends PHPUnit_Framework_TestCase {}