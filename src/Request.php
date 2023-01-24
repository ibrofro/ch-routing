<?php
namespace Routing;

use Routing\Interfaces\RequestInterface;
class Request {

    public $request;
    public $scheme;
    public $host;
    public $method;
    public $pathName;
    public $queryString;
    public $portNumber;
    protected $driver; 
    public function __construct(RequestInterface $driver){

        $this->driver = $driver;
        // Setup the values. 
        $this->scheme = $driver->getScheme(); 
        $this->host = $driver->getHost(); 
        $this->method = $driver->getMethod(); 
        $this->pathName = $driver->getPathname(); 
        $this->queryString = $driver->getQueryString(); 
        $this->portNumber = $driver->getPortNumber(); 
    
    }
    public function setMethod():self{

        $this->method = $this->driver->getMethod();
        return $this;
    }
    public function getMethod():string{

        return $this->method;
    }
    public function setScheme():self{
        $this->scheme = $this->driver->getScheme();
        return $this;
    }
    public function getScheme():string{
        return $this->scheme;
    }
    public function setHost():self{
        $this->host = $this->driver->getHost();
        return $this;
    }
    public function getHost():string{
        return $this->host;
    }
    public function setPortNumber():self{
        $this->portNumber = $this->driver->getPortNumber();
        return $this;
    }
    
    public function getPortNumber():int|string|null{
        return $this->portNumber;
    }
    public function setPathName():self{
        $this->pathName = $this->driver->getPathName();
        return $this;
    }
    public function getPathName():string{
        return $this->pathName;
    }
    public function setQueryString():self{
        $this->queryString = $this->driver->getQueryString();
        return $this;
    }
    public function getQueryString():?string{
        return $this->queryString;
    }
   
    
    
}