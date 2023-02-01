<?php
require "vendor/autoload.php";
use Symfony\Component\HttpFoundation\Request;
use Routing\Router;
use Routing\Drivers\SuperGlobalDriver;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
Router::get("/name/color");

// dd(Request::createFromGlobals()->getUri());
// $req = Request::create(
//     "http://www.go.com/product?color=red&price=2500"
// );


// dd($req->getQueryString(), $req->getPathInfo());

// dd(
//     $superGlobalDriver->getScheme(),
//     $superGlobalDriver->getMethod(),
//     $superGlobalDriver->getHost(),
//     $superGlobalDriver->getPortNumber(),
//     $superGlobalDriver->getQueryString()
// );
// dd(preg_match("//"))


Router::get(
    "/zone/location",
    [
        "_host" => "www.facebook.com",
        "_controller" => [stdClass::class, "locate"],
        "_regex" => ["name" => "/w+/"],
        "_additionnal" => ["request" => "second one"],
    ]
);
// Router::get(
//     "/name/color",
//     [
//         "_host" => "www.google.com",
//         "_controller" => [stdClass::class, "save"],
//         "_regex" => ["name" => "/w+/"],
//         "_scheme"=> "http",
//         // "_additionnal"=> ["request"=>$_SERVER],
//         "_additionnal" => ["request" => "Requesto"],


//     ]
// );
Router::match();
// dd(Router::$routesArr);
// $ins = new Route();

// // 1.Set the routes
// $ins::get("name/price/hello", [
//     "_page" => "france.php",
//     "_host" =>"www.hello.com",
//     "_controller"=> [Ecolo::class,["showProduct"]],
//     "_regex"=> [
//         "name"=>"\w+",
//         "price"=>"\d+",
//     ],
//     "additionnal" => [],
// ]);


// // 2.Set the request
// $request = [
//     "_uri"=>'/name/hello?name=bariq',
//     "_host"=>"www.fralo.com",
//     '_scheme'=>"GET",
//     'additionnal'=>["request"=> Request::class]

// ];
// $ins::setRequest($request);


// // 2.Set what the routing is going do 
// // when match successfully.
// try {
//     $ins::match(function($route,$request) {
//         // Load a page if exists;
//         $route->loadPage();
//         // Execute the route controller if exists.
//         $route->executeController();
// });

// } catch (RouteNotFoundException $th) {
//     // If none of the routes match the 
//     // Do wathever you want here.
//     throw new Exception("route not found");
// }

