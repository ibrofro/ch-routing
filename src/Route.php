<?php
namespace Routing;

class Route {

    protected $allowedMethods = ["get","put","post","patch","delete"];
    protected $pathname;
    protected $regex;
    protected $host;
    protected $controller;
    protected $additionnal;
    protected $method;
    protected $scheme;
    public function __construct(string $pathname){
        isset($pathname) ?: throw new \Exception("Pathname is not defined");    
        $this->setPathname($pathname);
    }
    public function setPathname(?string $pathname):self{
        isset($pathname) ?: throw new \Exception("Pathname is not defined");    
        $this->pathname = $pathname;
        return $this;
    }
    public function getPathname():string{
        return $this->pathname;
    }
    public function setHost(?string $host):self{
        $this->host = $host;
        return $this;
    }
    public function getHost():string|null{
        return $this->host;
    }
    public function setRegex(?array $regexArr):self{
        $this->regex = $regexArr;
        return $this;
    }
    public function getRegex():array|null{
        return $this->regex;
    }
    public function setScheme(?string $scheme):self{
        $this->scheme = $scheme;
        return $this;
    }
    public function getScheme():string|null{
        return $this->scheme;
    }
    public function getController():array|null{
        return $this->controller ;
    }

    public function setController(?array $controllerArr):self{
        isset($controllerArr[0]) ?  : throw new \Exception("Controller not defined");
        isset($controllerArr[1]) ?  : throw new \Exception("Please defined the method");
        $this->controller = $controllerArr;
        return $this;
    }
    public function setAdditionnal(?array $additionnalArr):self{
        $this->additionnal = $additionnalArr;
        return $this;
    }
    public function getAdditionnal():array|null{
        return $this->additionnal;
    }

    public function getMethod():string{
        return $this->method;
    }

    public function setMethod(string $method):self{
        if(!in_array($method,$this->allowedMethods)){
            throw new \Exception("Method not allowed");
        }
        $this->method = $method;
        return $this;
    }
    
}

