<?php

namespace php_hp_gallery\classes;

class PhgSetter
{
    public $category;
    public $file_name;
    public $title_jp;
    public $comment_jp;
    public $title_en;
    public $comment_en;

    function __construct($file_name){
        $this->category = isset($_POST["category"]) ? (int)$_POST["category"] : 0;
        $this->file_name = $file_name;
        $this->title_jp = isset($_POST["title_jp"]) ? $_POST["title_jp"] : "";
        $this->comment_jp = isset($_POST["comment_jp"]) ? $_POST["comment_jp"] : "";
        $this->title_en = isset($_POST["title_en"]) ? $_POST["title_en"] : "";
        $this->comment_en = isset($_POST["comment_en"]) ? $_POST["comment_en"] : "";
    }

    function get_line(){
        return $this->category . "|" . $this->file_name . "|" . $this->title_jp . "|" . $this->comment_jp . "|" . $this->title_en . "|" . $this->comment_en;
    }
}