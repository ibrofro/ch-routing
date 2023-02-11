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

    public function buildRegexForRoute(Route $route):array{
        $delimiter = "/";
        $regexArr = [];
        if($route->getScheme()){
            $regexArr["scheme"] = "^".preg_quote($route->getScheme(),$delimiter)."$";
        }

        if($route->getHost()){
            $regexArr["host"] = "^".preg_quote($route->getHost(),$delimiter)."$";
        }

        if($route->getPathname()){
            $regexArr["pathName"] = $this->putCaptureOnPathName($route);
        }

        return $regexArr;

    }
    /**
     * Escape the regex characters on string
     * @param string $string
     * @param string $delimiter The delimiter of the regex.
     * @param array $exceptArr Every character present of this array will be ignored.
     * @return string The escaped string 
     */
    public function escapeExcept($string,$delimiter,array $exceptArr = []):string{
        $escaped = preg_quote($string,$delimiter);
        foreach ($exceptArr as $value) {
            $escaped = str_replace("\\" . $value, $value, $escaped);
        }

        return $escaped;
    }
    /**
     * Put the capture on the route pathname
     * @param Route $route
     * @throws \Exception
     * @return string The pathname with the capture.
     */
    public function putCaptureOnPathName(Route $route):string{
        $captures = count($route->getCapture()) > 0 ? $route->getCapture() : [];
        $pathName = $route->getPathname();
        // escape regex characters except "{" and "}"
        $pathName = $this->escapeExcept($pathName, "/", ["{","}"]);
        foreach ($captures as $variable => $regex) {
            $findVariable = preg_match("/\{$variable\}/", $pathName,$founded,\PREG_OFFSET_CAPTURE);
            if($findVariable == 1){
                $offset = $founded[0][1];
                $length = strlen($founded[0][0]);
                $pathName = substr_replace($pathName, "(?P<".$variable.">".$regex.")", $offset, $length); 
            }else{
                throw new \Exception("capture " . $variable . " not found on the path");
            }
            
        }
        return "^".$pathName."$";
    }

    public function bindCapturedValueToRoute(Route $route,$matches){
        $captured = new \stdClass;
        foreach ($route->getCapture() as $key => $value) {
            $captured->$key = $matches[$key];
        }
        // Attach the captured variable on the route.
        $route->captured = $captured;
    }
    /**
     * Check the route that satifies the request 
     * depending on the different parameter of the
     * route.
     * @return Route|null
     */
    public function resolve():Route|null{
        foreach ($this->routes as $route) {
           $regexArr = $this->buildRegexForRoute($route);
           // loop on the regex returned by the route.
           foreach ($regexArr as $key => $regex) {
                $property = "get" . ucfirst($key);
                 
               if(!preg_match("/$regex/",$this->request->$property(),$matches)){
                    break;
                }
                // Get the capture when the regex is a pathname.
                if(($key === "pathName")){
                    // Attach the captured variable on the route.
                    $this->bindCapturedValueToRoute($route, $matches);
                }
                if($regex === end($regexArr)){
                    return $route;                            
                }
            }
        }
        return null;
    }
}