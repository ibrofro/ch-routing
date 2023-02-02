<?php
namespace Routing;

use Routing\Route;
use Routing\RouteCollection;
use Routing\Request;


class Resolver {

    public RouteCollection $routes;
    public Request $request;
    public function __construct(RouteCollection $routes,Request $request){
        $this->routes = $routes;
        $this->request = $request;
    }

    public function buildRegexForRoute(Route $route){
        $delimiter = "/";
        $regexArr = [];
        if($route->getScheme()){
            $regexArr[] = preg_quote($route->getScheme(),$delimiter);
        }

        if($route->getHost()){
            $regexArr[] = preg_quote($route->getHost(),$delimiter);
        }

        if($route->getPathname()){
            $regexArr[] = preg_quote($route->getPathname(),$delimiter);
        }

        return $regexArr;

    }

    public function resolve():Route|null{
        foreach ($this->routes as $route) {
           $regexArr = $this->buildRegexForRoute($route);
           // loop on the regex returned by the route.
           foreach ($regexArr as $regex) {
                // dd($regexArr);
               if(!preg_match("/$regex/",$this->request->getFullUrl())){
                    break;
                }
                if($regex === end($regexArr)){
                     return $route;                            
                }
            }
        }
        return null;
    }
}