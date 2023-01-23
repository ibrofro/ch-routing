<?php
namespace Routing;
use Routing\Route;
use Routing\RouteCollection;

class Router{

    const HOST = "_host";
    const PATHNAME = "_pathname";
    const REGEX = "_regex";
    const ADDITIONNAL = "_additionnal";
    const CONTROLLER = "_controller";

    /**
     * An array of routes
     * @var array
     */
    public static array $routesArr = [];
    /**
     * Destruct the object passed to a method eg:"get|post|..." 
     * @param array $obj an Array of options
     * @param Route $route An initialized route
     * @return Route
     */
    public static function objectDestructor($obj,Route $route):Route{

        !isset($obj[self::HOST])            ?: $route->setHost($obj[self::HOST]);
        !isset($obj[self::REGEX])           ?: $route->setRegex($obj[self::REGEX]);
        !isset($obj[self::ADDITIONNAL])     ?: $route->setAdditionnal($obj[self::ADDITIONNAL]);
        !isset($obj[self::CONTROLLER])      ?: $route->setController($obj[self::CONTROLLER]);
        
        return $route;

    }
    public static function get(string $pathname,array $obj){
        // 1.Initialize the route.
        $method = "get";
        $route = new Route($pathname);
        $route->setMethod($method);
        // 2.The Destructor will set all the methods needed.
        // based on the option the user defined.
        !isset($obj) ?  : self::objectDestructor($obj,$route);
        // 3.Add the route to the collection.
        array_push(self::$routesArr, $route);
    }
}