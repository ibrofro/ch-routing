<?php
require "vendor/autoload.php";
use Symfony\Component\HttpFoundation\Request;
use Routing\Router;
use Routing\Drivers\SuperGlobalDriver;
use Routing\Controllers\Product;
use Routing\Controllers\User;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

try {
    Router::get("/product/{name}/{color}",
        [
            "_controller" => [Product::class, "get"],
            "_regex" => ["name" => "/\w+/", "color" => "/\w+/"],
            "_host"=> "narvalo.localhost.com"
        ]
    );
    Router::post("/product/{name}/{color}",
        [
            "_controller" => [Product::class, "post"],
            "_regex" => ["name" => "/\w+/", "color" => "/\w+/"],
            "_host"=> "narvalo.localhost.com"
        ]
    );
    Router::put("/product/{name}/{color}",
        [
            "_controller" => [Product::class, "put"],
            "_regex" => ["name" => "/\w+/", "color" => "/\w+/"],
            "_host"=> "narvalo.localhost.com"
        ]
    );
    Router::patch("/product/{name}/{color}",
        [
            "_controller" => [Product::class, "patch"],
            "_regex" => ["name" => "/\w+/", "color" => "/\w+/"],
            "_host"=> "narvalo.localhost.com"
        ]
    );
    Router::delete("/product/{name}/{color}",
        [
            "_controller" => [Product::class, "delete"],
            "_regex" => ["name" => "/\w+/", "color" => "/\w+/"],
            "_host"=> "narvalo.localhost.com"
        ]
    );
    Router::match (function ($route, $request) {
        // Execute the route controller if exists.
        $data = [
            "route" => $route,
            "request" => $request,
            "captured" => $route->captured
        ];
        $route->executeController($data);
    });

} catch (Exception $e) {
    // If none of the routes match the 
    // Do wathever you want here.
    dd($e->getMessage());
}

















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
