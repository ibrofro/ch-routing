<?php
namespace Routing;
use Routing\Route;
class RouteCollection{

    protected array $items = [];

    public function getCollection(){
        return $this->items;
    }

    public function add(Route $route){
        array_push($this->items, $route);
    }

}