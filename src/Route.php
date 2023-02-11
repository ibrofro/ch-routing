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
    /**
     * The value of the captured part of the pathname.
     * @var \stdClass
     */
    public \stdClass $captured;
    
    /**
     * The captures set on the pathname like e.g => /price/{name}
     *
     * @var array
     */
    public array $capture = [];
    /**
     * The regex set by the user on route options 
     * e.g => ["_regex" => ["name"=>/w+/]]
     *
     * @var array
     */
    public array $userRegex = [];
    public function __construct(string $pathname){
        $this->setPathname($pathname);
    }
    public function setPathname(?string $pathname):self{
        isset($pathname) ?: throw new \Exception("Pathname is not defined");    
        preg_match("/^\//",$pathname)?: throw new \Exception("invalid pathname: the pathname ".$pathname." must start by '/'");
        $this->pathname = $pathname;

        return $this;
    }
    public function scanAndSetCapture(string $pathName):self{
        $this->capture = [];
        preg_match_all("#\{(.+?)\}#", $pathName, $matches,\PREG_OFFSET_CAPTURE | \PREG_SET_ORDER);
        foreach ($matches as $item) {
            $variable = $item[1][0];
            // set the regex when the user defined one.
            // if the user didn't specify a regex for 
            // the capture we replace with a defautl one.
            $regex = "[^\/]+";
            if(isset($this->regex[$variable])){
                $regex = $this->regex[$variable];
            }
            $this->capture[$variable] = $regex; 
        }
        return $this;                                                        
    }
    
    public function getCapture():array{
        return $this->capture;
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
    public function setRegex(array $regexArr):self{
        foreach ($regexArr as $name => $value) {

            // Check if regex is on the path.
            $variableToFind = preg_quote($name);
            $found = preg_match("/\{$variableToFind\}/", $this->pathname);
            if($found != 1){
                throw new \Exception('cannot add regex due to {'.$name.'} not defined on the path: '.$this->pathname);
            }

            // Check if user is not using option on the regex.
            $this->preventUserNotUsingPCREOption($value);

            // Check and remove the delimiter "/".
            $this->checkDelimiter($value,"/");
            $value = $this->trim($value,"/");

            $this->regex[$name] = $value;
        }

        // Check if the delimiter is / e.g /[a-z]

        $this->scanAndSetCapture($this->pathname);
        return $this;
    }

    public function preventUserNotUsingPCREOption($regex){
        $optionFound = preg_match("/\/.+\/[iDmsxUAJu]/",$regex);
        if($optionFound == 1){
            throw new \Exception("Can't use option after regex, use PCRE inline option instead");
        }
    }
    /**
     * check the delimiter; 
     * @param string $string
     * @param string $delimiter
     * @throws \Exception
     * @return void
     */
    public function checkDelimiter($string,$delimiter):void{
        if(strlen(trim($string,$delimiter)) !== (strlen($string)-2)){
            throw new \Exception("The delimiter of regex must be / e.g ['name'=>'/[a-z]/']");
        }        
    }
    /**
     * Trim the string; 
     * @param string $string
     * @param string $delimiter
     * @return string
     */
    public function trim($string,$delimiter){
        return trim($string, $delimiter);
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
    public function getController():array|callable|null{
        return $this->controller ;
    }

    public function setController(callable|array $controller):self{
        // Reset controller
        $this->controller = null;
        // If it's a callable
        if(is_callable($controller)){
            $this->controller = $controller;
            return $this;
        }
        $controllerArr = $controller;
        // If not a callable it should an array [namespace::class,"method"]
        is_array($controllerArr) ? : throw new \Exception("controller for route "
        .$this->pathname.
        " must be a callable or array[class,method]");
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

    public function executeController(array $data = []){
        if(empty($this->controller)){
            throw new \Exception("Controller for route "
             . $this->pathname . " not found");
        }

        if(is_callable($this->controller)){
            // call_user_func($this->controller,$data);
            return call_user_func_array($this->controller, $data);
        }

        // Verification wether controller is a callable
        // or class already done when we assign the controller to 
        // the route.
        $controller = $this->controller[0];
        $method = $this->controller[1];

        if(!class_exists($controller)){
            throw new \Exception("Class ".$controller." not found");
        }
        if(!method_exists($controller,$method)){
            throw new \Exception("method ".$method." not found on class ".$controller);
        }
        // Check if the class have a constructor
        $ins = new \ReflectionClass($controller);
        $constructor = $ins->getConstructor();
        if(!isset($constructor)){
            $controller = new $controller();
            return call_user_func_array(array($controller, $method), $data);
        }else{
            throw new \Exception("Your controller class have a constructor use a callback function to instantiate in your route. Please refer to documentation");
        }
        
    }
    
}

