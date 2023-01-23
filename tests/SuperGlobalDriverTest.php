<?php
use PHPUnit\Framework\TestCase;
use Routing\Route;
use Routing\Router;
use Routing\Drivers\SuperGlobalDriver;
use Routing\Interfaces\RequestInterface;
use Symfony\Component\HttpFoundation\Request;
use TheSeer\Tokenizer\Exception;

final class superGlobalDriverTest extends TestCase{

    public $uri;
    public $request;
    public $superGlobalDriver;
    public $scheme = "http://";
    public $host = "www.ch-routing.com";
    public $pathname = "/path/name";
    public $method = "GET";
    public $queryString = "?name=routing";
    public $portNumber = 80;
    public function setupRequest(){
        // Associate parameter to create a valid FQDN.
        $uri = $this->scheme . $this->host . $this->pathname. $this->queryString;
        // Create a fake request for the testing.
        $request = Request::create(
        $uri,
        $this->method,
    );
        $this->request = $request;
    }

    public function setupDriver(){
        // You need to setup the request first.
        if (!isset($this->request)):
          throw new Exception("You need to setup the driver first.");
        endif;  
        $this->superGlobalDriver = new SuperGlobalDriver($this->request);
    }

    public function setupTestDependencies(){
        $this->setupRequest();
        $this->setupDriver();
    }
    protected function setUp():void
    {
        // code to execute before first test of the class
        $this->setupTestDependencies();
    }
    public function testgetMethod(){
        $this->assertSame($this->method, $this->superGlobalDriver->getMethod());
    }
    public function testgetScheme(){
        $scheme =  str_replace("://","",$this->scheme);
        $this->assertSame($scheme, $this->superGlobalDriver->getScheme());
        
    }
    public function testgetHost(){
        $this->assertSame($this->host, $this->superGlobalDriver->getHost());
        
    }
    public function testgetportNumber(){
        $this->assertSame($this->portNumber, $this->superGlobalDriver->getPortNumber());
        
    }
    public function testgetqueryString(){
        $this->assertSame(substr($this->queryString,1), $this->superGlobalDriver->getQueryString());
        
    }

    public function testpathName(){
        $this->assertSame($this->pathname, $this->superGlobalDriver->getPathName());
        
    }

   



  

}