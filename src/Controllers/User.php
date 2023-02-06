<?php
namespace Routing\Controllers;
class User  
{
    public $name;
    public $nickName;
    public function __construct($nickName,$name){
        $this->name = $name;
        $this->nickName = $nickName;
    }

    public function display(){
        echo $this->nickName . " " . $this->name;
    }
}
