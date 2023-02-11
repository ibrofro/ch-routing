<?php
namespace Routing\Controllers;

class Product{


    public function save($route,$request,$captured){
        $ra = $request->getRequestObject();
        dd($ra);
        echo "Hey this is the save method";
    }
} 