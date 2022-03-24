<?php

namespace php_hp_gallery\classes;

class State
{
    public $lang;
    public $pic;
    public $category;

    function __construct(){
        $this->lang = isset($_GET["lang"]) ? (int)$_GET["lang"] : 0;
        $this->pic = isset($_GET["pic"]) ? (int)$_GET["pic"] : null;
        $this->category = isset($_GET["category"]) ? (int)$_GET["category"] : null;
    }
}