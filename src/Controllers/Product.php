<?php
namespace Routing\Controllers;
use Symfony\Component\HttpFoundation\Request;
class Product{


    public function get($route,$request,$captured){
        $request = $request->getRequestObject();
        dd($request->query);
        echo "Hey this is the get method";
    }

    public function post($route,$request,$captured){
        $request = $request->getRequestObject();
        dd($request->request);
        echo "Hey this is the put method";
    }
    public function put($route,$request,$captured){

        echo "Hey this is the post method";
    }
    public function patch($route,$request,$captured){

        echo "Hey this is the patch method";
    }
    public function delete($route,$request,$captured){

        echo "Hey this is the delete method";
    }
} 