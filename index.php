<?php
require "vendor/autoload.php";
use Routing\Route;


$tab = ["name" => "cherif"];
$tao = ["name" => "cherif"];
dd($tao === $tab);
// dd($_REQUEST);

$route = new Route("/color/price");
// var_dump($_REQUEST);
dd(Route::get("/name/war",
[
    "_host"=>"www.google.com",
    "_controller"=>[Route::class,"save"],
    "_regex"=> ["name"=>"/w+/"],
    "_additionnal"=> ["request"=>$_SERVER],

]));


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







