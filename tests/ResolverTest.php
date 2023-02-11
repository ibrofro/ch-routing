<?php
use PHPUnit\Framework\TestCase;
use Routing\Drivers\SuperGlobalDriver;
use Routing\Route;
use Routing\RouteCollection;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Routing\Request;
use Routing\Resolver;
use Routing\Router;
final class ResolverTest extends TestCase{

    public string $uri;
    public  Routing\Request $request;
    public  HttpFoundationRequest $httpFoundationRequest;
    public  SuperGlobalDriver $superGlobalDriver;
    public string $scheme = "http://";
    public string $host = "www.ch-routing.com";
    public string $pathname = "/path/name";
    public string $method = "GET";
    public string $queryString = "?name=routing";
    public int $portNumber = 80;

    public function setupRequest(){
        // Associate parameter to create a valid FQDN.
        $uri = $this->scheme . $this->host . $this->pathname. $this->queryString;
        // Change the uri set on method for testing.
        $uri = empty($this->uri) ? $uri : $this->uri;
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
    public function resetProperties(array $properties):void
    {
        // Reset all the dependencies.
        foreach ($properties as $property) {
            if(!isset($this->{$property})){
                continue;
            }
            $this->{$property} = null;
        }
    }
    public function testResolve(){
        // Creating routes.
        $route1 = new Route("/test/first");
        $route1->setHost("www.test-random.com");
        $route2 = new Route("/test/second");
        $route2->setHost("www.test-random.com");
        $arrayOfRoutes[] = $route1;
        $arrayOfRoutes[] = $route2;
        // Creating the collection for the routes.
        $routesCollection = new RouteCollection($arrayOfRoutes);

        // Setting up the uri
        $this->uri = "http://www.test-random.com/test/first";
        $this->setupTestDependencies();

        // Resolver
        $resolver = new Resolver($routesCollection,$this->request);
        
        // Test accepted route.
        $routeAccepted = $resolver->resolve();
        $this->assertSame($routeAccepted, $route1);
        // Test Scheme
        $route1->setScheme("https");
        $routeAccepted = $resolver->resolve();
        $this->assertEmpty($routeAccepted);


    }
    public function testbuildRegexForRoute(){
        // Creating routes.
        $route1 = new Route("/test/first");
        $route1->setHost("www.test-random.com");
         // Setting up the uri
         $this->uri = "http://www.test-random.com/test/first";
        // Creating the collection for the routes.
        $routesCollection = new RouteCollection([$route1]);

        // Resolve the routes
        $resolver = new Resolver($routesCollection,$this->request);
        $regex = $resolver->buildRegexForRoute($route1);
        $expectedRegex1 = "^www\.test\-random\.com$";
        $expectedRegex2 = "^\/test\/first$";
        // dd($expe)
        $this->assertCount(2, $regex);
        $this->assertEquals($expectedRegex1, $regex["host"]);
        $this->assertEquals($expectedRegex2, $regex["pathName"]);

    }
    public function testescapeExcept(){
        // Setting up the uri
        $this->uri = "http://www.test-random.com/product/shoe/120/en";
        $this->setupTestDependencies();
        $route = new Route("/product/{name}/{price}/{lang}");
        $routesCollection = new RouteCollection([$route]);
        $resolver = new Resolver($routesCollection,$this->request);
        $escaped = $resolver->escapeExcept($route->getPathname(),"/",["{","}"]);
        $expect = "\/product\/{name}\/{price}\/{lang}";
        $this->assertEquals($expect, $escaped);
   }
    public function testputCaptureOnPathName(){
         // Setting up the uri
         $this->uri = "http://www.test-random.com/product/shoe/120/en";
         $this->setupTestDependencies();

        $route = new Route("/product/{name}/{price}/{lang}/{country}");
        $routesCollection = new RouteCollection([$route]);
        $route->setRegex(["name" => "/\w+/", "price" => "/\d+/","lang" => "/\w{2}/"]);
        $resolver = new Resolver($routesCollection,$this->request);
        $expected = "^\/product\/(?P<name>\w+)\/(?P<price>\d+)\/(?P<lang>\w{2})\/(?P<country>[^\/]+)$";
        $pathName = $resolver->putCaptureOnPathName($route);
        $this->assertEquals($expected, $pathName);
    }
    public function testbindCapturedValueToRoute(){
        // Setting up the uri
        $this->uri = "http://www.test-random.com/product/shoe/120/en/fr";
        $this->setupTestDependencies();
        $route = new Route("/product/{name}/{price}/{lang}/{country}");
        $routesCollection = new RouteCollection([$route]);
        $route->setRegex(["name" => "/\w+/", "price" => "/\d+/","lang" => "/\w{2}/"]);
        $matches = ["name" => "shoe", "price" => "1200", "lang" => "en","country"=>"fr"];
        $resolver = new Resolver($routesCollection,$this->request);
        $resolver->bindCapturedValueToRoute($route, $matches);

        $this->assertEquals("shoe", $route->captured->name);
        $this->assertEquals("1200", $route->captured->price);
        $this->assertEquals("en", $route->captured->lang);
        $this->assertEquals("fr", $route->captured->country);
    }

   



  

}