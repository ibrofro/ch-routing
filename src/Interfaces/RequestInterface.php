<?php
namespace Routing\Interfaces;
Interface RequestInterface{

    
    public function getScheme():string;
    public function getMethod():string;
    public function getHost():string;
    public function getPathName():string;
    public function getPortNumber():int|string|null;
    public function getQueryString():?string;
    // If the user need to have more than 
    // what we specified here, check out the default
    // implementation for more information.
    public function getRequestObject();

    
}