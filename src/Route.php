<?php
namespace Routing;
use TheSeer\Tokenizer\Exception;

class Route {


    protected  $pathname;
    protected  $regex;
    protected  $host;
    protected  $controller;
    protected  $additionnal;
    protected $request;


    
    public function __construct(string $pathname){
        $this->setPathname($pathname);
    }
    public function setPathname(?string $pathname):self{
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
    public function getHost():string{
        return $this->host;
    }
    public function setRegex(?array $regexArr):self{
        $this->regex = $regexArr;
        return $this;
    }
    public function getRegex():array{
        return $this->regex;
    }
    public function getController():array{
        return $this->controller ;
    }

    public function setController(?array $controllerArr):self{
        isset($controllerArr[0]) ?  : throw new Exception("Controller not defined");
        isset($controllerArr[1]) ?  : throw new Exception("Please defined the method");
        $this->controller = $controllerArr;
        return $this;
    }
    public function setAdditionnal(?array $additionnalArr):self{
        $this->additionnal = $additionnalArr;
        return $this;
    }
    public function getAdditionnal():array{
        return $this->additionnal;
    }



    
    /**
     * The HTTP get method 
     * @param string $pathname
     * @param array $obj
     * @return self
     */
    // static function get(string $pathname,array $obj){
    //     // The pathname is mandatory.
    //     if(!isset($pathname)){
    //         throw new \Exception("The pathname is mandatory");
    //     }

    //     // Create an instance of this class.
    //     $instance =  new self(
    //         $pathname,
    //         $obj["_regex"] ?? null,
    //         $obj["_host"] ?? null,
    //         $obj["_controller"] ?? null,
    //         $obj["_additionnal"] ?? null,
    //     );

    //     dd($instance);
    //     // Add it to the collection of Route.
    //     self::addToCollection($instance);
    //     return $_host;
    // }

    







}

