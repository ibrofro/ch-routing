<?php
use PHPUnit\Framework\TestCase;
use Routing\Router;
use Routing\Route;

final class RouterTest extends TestCase{

    public function testobjDestructor(){
        $fakePath = "/model/color";
        $route = new Route($fakePath);
        $fakeOptions = [
            "_host" => "www.test.com",
            "_controller" => [stdClass::class, "save"],
            "_regex" => ["model" => "/w+/"],
            "_additionnal" => ["request" => "Requesto"]
        ];
        Router::objectDestructor($fakeOptions,$route);
        // All option should be attached to route now !
        $this->assertSame($route->getHost(), $fakeOptions["_host"]);
        $this->assertSame($route->getController(), $fakeOptions["_controller"]);
        $this->assertSame($route->getRegex(), $fakeOptions["_regex"]);
        $this->assertSame($route->getAdditionnal(), $fakeOptions["_additionnal"]);
   }




   
    

   

}