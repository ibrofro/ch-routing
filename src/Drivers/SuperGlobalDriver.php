<?php
namespace Routing\Drivers;
use Routing\Interfaces\RequestInterface;
class SuperGlobalDriver implements RequestInterface{

    public $request; 
    public function __construct($request){

        $this->request = $request;
    }
    public function getMethod():string{

        return $this->request->getMethod();
    }
    public function getScheme():string{
        return $this->request->getScheme();
    }
    public function getHost():string{
        return $this->request->getHost();
    }

    public function getPortNumber():int|string|null{
        return $this->request->getPort();
    }

    public function getPathName():string{
        return $this->request->getPathInfo();
    }
    public function getQueryString():?string{
        return $this->request->getQueryString();
    }

    public function getRequestObject(){
        return $this->request;
    }
    
}