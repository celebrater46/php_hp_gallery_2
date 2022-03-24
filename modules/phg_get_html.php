<?php

namespace php_hp_gallery\modules;

use php_hp_gallery\classes\Category;
use php_hp_gallery\classes\State;

require_once "html_common_module.php";

function get_lang_links($state){
    $html = space_br("<div class='lang'>", 1);
    $html .= space_br("<a href='" . PHG_INDEX_FILE_NAME . "?lang=" . $state->lang . "&pic=" . $state->pic . "'>", 2);
    $html .= space_br($state->lang === 1 ? "日本語" : "ENGLISH", 3);
    $html .= space_br("</div>", 2);
    return $html;
}

function get_picture_page($picture, $state){
    $html = space_br("<div>", 1);
    $html .= space_br("<a href='" . PHG_INDEX_FILE_NAME . "?lang=" . $state->lang . "'>", 2);
    if(file_exists($picture->file_name)){
        $html .= space_br('<img class="gallery pic' . ($picture->is_wide ? " x" : "") . '" src="' . PHG_IMAGES_DIR_HTTP . "/" . $picture->file_name . '">', 3);
    } else {
        echo "NOT FOUND: " . $picture->file_name . "<br>";
    }
    $html .= space_br("</a>", 2);
    $html .= space_br("</div>", 1);
    $html .= space_br("<div class='texts'>", 1);
    $html .= space_br("<h1>" . $picture->title . "</h1>", 2);
    $html .= space_br("<h2>" . $picture->comment . "</h2>", 2);
    $html .= space_br("</div>", 1);
    $html .= space_br("<div class='back'>", 1);
    $html .= space_br("<a href='" . PHG_INDEX_FILE_NAME . "?lang=" . $state->lang . "'>" . ($state->lang === 1 ? "BACK" : "戻る") . "</a>", 2);
    $html .= space_br("</div>", 1);
    return $html;
}

function get_category_div($category, $state){
    $html = space_br("<h2>" . $category->name . "</h2>", 1);
    $html .= space_br("<div class='thumbs'>", 1);
    foreach ($category->pictures as $pic){
        if(file_exists($pic->thumb)){
            $html .= space_br("<div class='thumb box'>", 2);
            $html .= space_br('<a href="' . PHG_INDEX_FILE_NAME . '?lang=' . $state->lang . '&pic=' . $pic->id . '">', 3);
            $html .= space_br('<img src="' . PHG_THUMBNAIL_DIR_HTTP . "/" . $pic->thumb . '">', 4);
            $html .= space_br('</a>', 3);
            $html .= space_br("</div>", 2);
        } else {
            echo "NOT FOUND: " . $pic->thumb . "<br>";
        }
    }
    $html .= space_br("</div>", 1);
    return $html;
}

function get_categories($state){
    $categories_lines = get_list("categories.txt");
    $array = [];
    foreach ($categories_lines as $line){
        array_push($array, new Category($line, $state));
    }
    return $array;
}

function phg_get_html($state) {
//    $images_lines = get_list("images.txt");
//    $categories_lines = get_list("categories.txt");
//    $state = new State();
    $categories = get_categories($state);
    if($state->pic === null){
        $html = space_br("<h1>" . PHG_SITE_NAME[$state->lang] . "</h1>", 1);
        if($state->category === null){
            foreach ($categories as $category){
                $html .= get_category_div($category, $state);
            }
        } else {
            $html .= get_category_div($categories[$state->category], $state);
        }
    } else {
        $html = get_picture_page($categories[$state->category]->pictures[$state->pic], $state);
    }
    $html .= get_lang_links($state);
    return $html;
}