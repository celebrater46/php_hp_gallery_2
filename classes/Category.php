<?php

namespace php_hp_gallery\classes;

use function php_hp_gallery\modules\get_list;

class Category
{
    public $id;
    public $name;
    public $pictures = [];

    function __construct($line, $state){
        $items = explode("|", $line); // num|名前|name|directory
        $this->id = (int)$items[0];
        $this->name = [ $items[1], $items[2] ];
        $this->pictures = $this->get_pictures($state);
    }

    function get_pictures($state){
        $images = get_list("images.txt");
        $pics = [];
        if($images !== null){
            $i = 0;
//            var_dump($images);
            foreach ($images as $line){
                $items = explode("|", $line);
//                var_dump($items);
//                $category = (int)items[0]; // Fatal error: Uncaught Error: Undefined constant
                $category = (int)$items[0];
                if($category === $this->id){
                    array_push($pics, new Picture($i, $this->id, $items, $state->lang));
                    $i++;
                }
            }
            return $pics;
        } else {
            return null;
        }
    }
}