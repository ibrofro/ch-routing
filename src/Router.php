<?php
namespace Routing;
use Routing\Drivers\SuperGlobalDriver;
use Routing\Route;
use Routing\RouteCollection;
use Routing\Resolver;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Router{

    const HOST = "_host";
    const PATHNAME = "_pathname";
    const REGEX = "_regex";
    const ADDITIONNAL = "_additionnal";
    const CONTROLLER = "_controller";
    const SCHEME = "_scheme";


    /**
     * An array of routes
     * @var array
     */
    public static array $routesArr = [];
    /**
     * @var RouteCollection
     */
    public RouteCollection $routeCollection;
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
        !isset($obj[self::SCHEME])          ?: $route->setScheme($obj[self::SCHEME]);
        
        return $route;

    }
    public static function get(string $pathname,array $obj = []){
        // 1.Initialize the route.
        $method = "get";
        $route = new Route($pathname);
        $route->setMethod($method);
        // 2.The Destructor will set all the methods needed.
        // based on the option the user defined.
        empty($obj) ?  : self::objectDestructor($obj,$route);
        // 3.Add the route to the collection.
        array_push(self::$routesArr, $route);
    }

    private static function initializeCollection(array $arr):RouteCollection{

        if(count($arr) == 0):
            throw new \Exception("No route defined");
        endif;

        return new RouteCollection(self::$routesArr);
    }

    public static function getRouteCollection():RouteCollection{
        return self::$routeCollection;
    }

    public static function match ()
    {
        // Initialize collection.
        $collection = self::initializeCollection(self::$routesArr);
        // Get the request.
        $driver = new SuperGlobalDriver(SymfonyRequest::createFromGlobals());
        $request = new Request($driver);
        // Resolve the route
        $resolver = new Resolver($collection, $request);
        $resolver->resolve();

        // match
        // if match execute callback.
        // $fn($route, $request);
        // Throw Exception.
    }
}