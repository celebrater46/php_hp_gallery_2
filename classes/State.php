<?php

namespace php_hp_gallery\classes;

class State
{
    public $lang;
    public $pic;
    public $category;
    public $page;
    public $mode; // 自サイト用

    function __construct(){
        $this->lang = isset($_GET["lang"]) ? (int)$_GET["lang"] : 0;
        $this->pic = isset($_GET["pic"]) ? (int)$_GET["pic"] : -1;
        $this->category = isset($_GET["category"]) ? (int)$_GET["category"] : -1;
        $this->page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
        $this->mode = isset($_GET["mode"]) ? (int)$_GET["mode"] : 0;
    }

//    function get_additional_nums($str, $num){
//        $array = [
//            "lang" => $this->lang,
//            "mode" => $this->mode,
//            "pic" => $this->pic,
//            "category" => $this->category,
//            "page" => $this->page
//        ];
//        if($str !== ""){
//            $array[$str] = $num;
//        }
//        return $array;
//    }

    function get_url_parameters_to_top(){
        return "lang=" . $this->lang . "&mode=" . $this->mode . "&category=-1&pic=-1";
//        return "lang=" . $this->lang . "&mode=" . $this->mode . "&category=-1&pic=-1&page=" . $this->page;
    }

    function get_new_link($array){
        $temp_array = [
            "lang" => $this->lang,
            "mode" => $this->mode,
            "pic" => $this->pic,
            "category" => $this->category
//            "page" => $this->page
        ];
        foreach ($array as $key => $num){
            //$key_num === ["lang", 1];
            $temp_array[$key] = $num;
        }
        return $temp_array;
    }

    function get_new_url_parameters($array){
        $new_parameters = $this->get_new_link($array);
        $str = "";
        foreach ($new_parameters as $key => $num){
            if($num === null || $num === -1){
                continue;
            }
//            $str .= ($key === "lang" ? "?" : "&") . $key . "=" . $num;
            $str .= ($key === "lang" ? "" : "&") . $key . "=" . $num;
        }
        return $str;
    }

//    function get_url_parameters($array){
//        $nums = $this->get_additional_nums($array);
//        return "lang=" . $nums["lang"] . "&mode=" . $nums["mode"] . "&category=" . $nums["category"] . "&pic=" . $nums["pic"] . "&page=" . $nums["page"];
////        return "?lang=" . $this->lang . "&category=" . $this->category . "&pic=" . $this->pic . "&page=" . $this->page;
//    }
}