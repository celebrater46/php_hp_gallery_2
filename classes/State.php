<?php

namespace php_hp_gallery\classes;

class State
{
    public $lang;
    public $pic;
    public $category;
    public $page;

    function __construct(){
        $this->lang = isset($_GET["lang"]) ? (int)$_GET["lang"] : 0;
        $this->pic = isset($_GET["pic"]) ? (int)$_GET["pic"] : -1;
        $this->category = isset($_GET["category"]) ? (int)$_GET["category"] : -1;
        $this->page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    }

    function get_additional_nums($str, $num){
        $array = [
            "lang" => $this->lang,
            "pic" => $this->pic,
            "category" => $this->category,
            "page" => $this->page
        ];
        if($str !== ""){
            $array[$str] = $num;
        }
        return $array;
    }

    function get_url_parameters_to_top(){
        return "?lang=" . $this->lang . "&category=-1&pic=-1&page=" . $this->page;
    }

    function get_url_parameters($str, $num){
        $nums = $this->get_additional_nums($str, $num);
        return "?lang=" . $nums["lang"] . "&category=" . $nums["category"] . "&pic=" . $nums["pic"] . "&page=" . $nums["page"];
//        return "?lang=" . $this->lang . "&category=" . $this->category . "&pic=" . $this->pic . "&page=" . $this->page;
    }
}