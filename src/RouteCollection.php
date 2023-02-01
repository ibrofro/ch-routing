<?php
namespace Routing;
use Routing\Route;
use IteratorAggregate;
use ArrayIterator;
class RouteCollection implements IteratorAggregate{

    protected array $items = [];

    public function __construct(array $data){
        $this->items = $data;
    }
    public function getCollection(){
        return $this->items;
    }
    public function getIterator() {
        return new ArrayIterator($this->items);
    }
    public function add(Route $route){
        array_push($this->items, $route);
    }

}