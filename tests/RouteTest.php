<?php
use PHPUnit\Framework\TestCase;
use Routing\Route;
use Routing\Router;

final class RouteTest extends TestCase
{

    public function testgetPathname()
    {
        $route = new Route("/model/color");
        $this->assertSame("/model/color", $route->getPathname());
    }

    public function testsetPathname()
    {
        $route = new Route("/model/color");
        $newPath = "/model/reset";
        $route->setPathname($newPath);
        $this->assertSame($newPath, $route->getPathname());
    }

    public function testsetRegex()
    {
        $fakePath = "/{model}/{color}";
        $fakeRegex = [
            "model" => "/w+/",
            "color" => "/\d+/"
        ];
        $expectedRegex = [
            "model" => "w+",
            "color" => "\d+"
        ];
        $route = new Route($fakePath);
        $route->setRegex($fakeRegex);
        $this->assertSame($expectedRegex, $route->getRegex());
        // Test setting regex without capturing it on the pathname
        $fake = [
            "model" => "/d+/",
            "color" => "/w+/",
            "notexist" => "/[a-z]/"
        ];
        
        $this->expectException(Exception::class);
        $route->setRegex($fake);
    }
    public function testgetRegex()
    {
        $fakePath = "/{model}/color";
        $fakeRegex = ["model" => "/\w+/"];
        $expectedRegex = ["model" => "\w+"];
        $route = new Route($fakePath);
        $route->setRegex($fakeRegex);
        $this->assertSame($expectedRegex, $route->getRegex());
    }
    public function testsetHost()
    {
        $fakePath = "/model/color";
        $fakeHost = "www.test.com";
        $route = new Route($fakePath);
        $route->setHost($fakeHost);
        $this->assertSame($fakeHost, $route->getHost());
    }
    public function testgetHost()
    {
        $fakePath = "/model/color";
        $fakeHost = "www.test.com";
        $route = new Route($fakePath);
        $route->setHost($fakeHost);
        $this->assertSame($fakeHost, $route->getHost());
    }

    public function testsetController()
    {

        $fakePath = "/model/color";
        $fakeController = [stdClass::class, "testMethod"];
        $route = new Route($fakePath);
        $route->setController($fakeController);
        $this->assertSame($fakeController, $route->getController());
    }

    public function testgetAdditionnal()
    {

        $fakePath = "/model/color";
        $fakeAditionnal = ["name" => "ch-routing"];
        $route = new Route($fakePath);
        $route->setAdditionnal($fakeAditionnal);
        $this->assertSame($fakeAditionnal, $route->getAdditionnal());
    }
    public function testgetMethod()
    {
        $fakePath = "/model/color";
        $fakeMethod = "get";
        $route = new Route($fakePath);
        $route->setMethod($fakeMethod);
        $this->assertSame($fakeMethod, $route->getMethod());

    }

    public function testsetMethod()
    {
        $fakePath = "/model/color";
        $route = new Route($fakePath);
        $this->expectException(Exception::class);
        $route->setMethod("GETT");
    }

    public function testexecuteController()
    {
        $fakePath = "/model/color";
        $route = new Route($fakePath);

        // Test for callback controller.
        $route->setController(function ($param) {
            return $param;
        });
        $result = $route->executeController(["param" => "ok"]);
        $this->assertSame($result, "ok");

        // Test for class controller.
        $class = new class () {
            public function withParam($name)
            {
                return $name;
            }
        };
        $route->setController([$class::class, "withParam"]);
        $result = $route->executeController(["name" => "woufwouf"]);
        $this->assertSame($result, "woufwouf");



        // Test for class controller with constructor
        $route->setController(function () {
            $name = "wouwwouw";
            $class = new class ($name) {
                public $name;
                public function __construct($name)
                {
                    $this->name = $name;
                }
                public function sayName()
                {
                    return $this->name;
                }
            };
            return $class->sayName();
        });
        $result = $route->executeController();
        $this->assertSame($result, "wouwwouw");

        // Test for class controller with constructor
        // Passing data
        $route->setController(function ($location) {
            $name = "wouwwouw";
            $class = new class ($name) {
                public $name;
                public function __construct($name)
                {
                    $this->name = $name;
                }
                public function sayName($location)
                {
                    return $this->name . " " . $location;
                }
            };
            return $class->sayName($location);
        });
        $result = $route->executeController(["location" => "Baltimore"]);
        $this->assertSame($result, "wouwwouw Baltimore");
    }

    public function testscanAndSetCapture()
    {
        $fakePath = "/product/{price}/{color}/{lang}";
        $route = new Route($fakePath);
        $route->setRegex([
            "price"=>"/d+/",
            "color"=>"/w+/"
            ]);
        
        $attempt = [
                "price"=>"d+",
                "color"=>"w+",
                "lang"=>"[^\/]+"
                ];
        $route->scanAndSetCapture($fakePath);
        $this->assertEquals($route->getCapture(), $attempt);
       

    }
    public function testpreventUserNotUsingPCREOption()
    {
        $fakePath = "/product/{price}/{color}/{lang}";
        $route = new Route($fakePath);
        $this->expectException(Exception::class);
        $route->setRegex([
            "price" => "/d+/i",
            "color" => "/w+/"
        ]);

    }
    public function testcheckDelimiter()
    {
        $fakePath = "/product/{price}/{color}/{lang}";
        $route = new Route($fakePath);
        $this->assertNull($route->checkDelimiter("/d+/","/"));
        $this->expectException(Exception::class);
        $route->checkDelimiter("/d+","/");
    }

}