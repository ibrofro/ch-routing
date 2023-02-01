<?php
use PHPUnit\Framework\TestCase;
use Routing\Drivers\SuperGlobalDriver;
use Routing\RouteCollection;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Routing\Request;
use Routing\Resolver;
use Routing\Router;
final class ResolveTest extends TestCase{

    public $uri;
    public $request;
    public  $httpFoundationRequest;
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
        $httpFoundationRequest = HttpFoundationRequest::create(
        $uri,
        $this->method,
    );
        $this->httpFoundationRequest = $httpFoundationRequest;
    }

    public function setupDriver(){
        // You need to setup the request first.
        if (!isset($this->httpFoundationRequest)):
          throw new \Exception("You need to setup the driver first.");
        endif;  
        $this->superGlobalDriver = new SuperGlobalDriver($this->httpFoundationRequest);

    }

    public function initializeRequest(){
        $this->request = new Request($this->superGlobalDriver);
    }

    public function setupTestDependencies(){
        $this->setupRequest();
        $this->setupDriver();
        $this->initializeRequest();
    }
    protected function setUp():void
    {
        // code to execute before first test of the class
        $this->setupTestDependencies();
    }
    public function testbuildRegexForRoute(){
        Router::get("test/first", ["_host" => "www.ch-routing.com"]);
        Router::get("test/first", ["_host" => "www.ch-routing.com"]);
        $routes = Router::getRouteCollection();
        $resolver = new Resolver($routes,$this->request);
        $routeAccepted = $resolver->resolve();
        dd($routeAccepted);
        $this->assertSame($this->method, $this->request->getMethod());
    }
    public function testgetScheme(){
        $scheme =  str_replace("://","",$this->scheme);
        $this->assertSame($scheme, $this->request->getScheme());
        
    }
    public function testgetHost(){
        $this->assertSame($this->host, $this->request->getHost());
        
    }
    public function testgetportNumber(){
        $this->assertSame($this->portNumber, $this->request->getPortNumber());
        
    }
    public function testgetqueryString(){
        $this->assertSame(substr($this->queryString,1), $this->request->getQueryString());
        
    }

    public function testpathName(){
        $this->assertSame($this->pathname, $this->superGlobalDriver->getPathName());
        
    }

   



  

}