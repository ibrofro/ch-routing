<?php
use PHPUnit\Framework\TestCase;
use Routing\Route;
final class RouteTest extends TestCase{

    public function testgetPathname(){
        $route = new Route("/model/color");
        $this->assertSame("/model/color", $route->getPathname());
    }

    public function testsetPathname(){
        $route = new Route("/model/color");
        $newPath = "/model/reset";
        $route->setPathname($newPath);
        $this->assertSame($newPath, $route->getPathname());
    }
    
    public function testsetRegex(){
        $fakePath = "/model/color";
        $fakeRegex = [
            "model" => "/w+/",
            "color" => "/\d+/"
        ];
        $route = new Route($fakePath);
        $route->setRegex($fakeRegex);
        $this->assertSame($fakeRegex, $route->getRegex());
    }
    public function testgetRegex(){
        $fakePath = "/model/color";
        $fakeRegex = ["model" => "/\w+/"];
        $route = new Route($fakePath);
        $route->setRegex($fakeRegex);
        $this->assertSame($fakeRegex, $route->getRegex());
    }
    public function testsetHost(){
        $fakePath = "/model/color";
        $fakeHost = "www.test.com";
        $route = new Route($fakePath);
        $route->setHost($fakeHost);
        $this->assertSame($fakeHost, $route->getHost());
    }
    public function testgetHost(){
        $fakePath = "/model/color";
        $fakeHost = "www.test.com";
        $route = new Route($fakePath);
        $route->setHost($fakeHost);
        $this->assertSame($fakeHost, $route->getHost());
    }

    public function testsetController(){
       
        $fakePath = "/model/color";
        $fakeController = [stdClass::class, "testMethod"];
        $route = new Route($fakePath);
        $route->setController($fakeController);
        $this->assertSame($fakeController,$route->getController());
    }

    public function testgetAdditionnal(){
       
        $fakePath = "/model/color";
        $fakeAditionnal = ["name" => "ch-routing"];
        $route = new Route($fakePath);
        $route->setAdditionnal($fakeAditionnal);
        $this->assertSame($fakeAditionnal,$route->getAdditionnal());
    }



   

}