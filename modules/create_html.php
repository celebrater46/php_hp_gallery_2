<?php

namespace php_hp_gallery\modules;

use php_hp_gallery\classes\Category;

require_once( dirname(__FILE__) . '/../classes/Category.php');

function get_lang_links($state){
    $html = space_br("<div class='lang'>", 1);
    $html .= space_br("<a href='" . PHG_INDEX_FILE_NAME . "?lang=" . ($state->lang === 1 ? "0" : "1") . "&category=" . $state->category . "&pic=" . $state->pic . "'>", 2);
    $html .= space_br($state->lang === 1 ? "日本語" : "ENGLISH", 3);
    $html .= space_br("</div>", 2);
    return $html;
}

function get_picture_page($picture, $state){
    $img = PHG_IMAGES_DIR_HTTP . "/" . $picture->file_name;
    $html = space_br("<div>", 1);
    $html .= space_br("<a href='" . PHG_INDEX_FILE_NAME . "?lang=" . $state->lang . "'>", 2);
    if(file_exists($img)){
        $html .= space_br('<img class="gallery pic' . ($picture->is_wide ? " x" : "") . '" src="' . $img . '">', 3);
    } else {
        echo "NOT FOUND: " . $picture->file_name . "<br>";
    }
    $html .= space_br("</a>", 2);
    $html .= space_br("</div>", 1);
    if($picture->title !== ""){
        $html .= space_br("<div class='texts'>", 1);
        $html .= space_br("<h1>" . $picture->title . "</h1>", 2);
        $html .= space_br("<h2>" . $picture->comment . "</h2>", 2);
        $html .= space_br("</div>", 1);
    }
    $html .= space_br("<div class='back'>", 1);
    $html .= space_br("<a href='" . PHG_INDEX_FILE_NAME . "?lang=" . $state->lang . "'>" . ($state->lang === 1 ? "BACK" : "戻る") . "</a>", 2);
    $html .= space_br("</div>", 1);
    return $html;
}

function get_category_div($category, $state){
    $html = space_br("<h2>" . $category->name[$state->lang] . "</h2>", 1);
    $html .= space_br("<div class='thumbs'>", 1);
    foreach ($category->pictures as $pic){
        $thumb = PHG_THUMBNAIL_DIR_HTTP . "/" . $pic->thumb;
        if(file_exists($thumb)){
            $html .= space_br("<div class='thumb box'>", 2);
            $html .= space_br('<a href="' . PHG_INDEX_FILE_NAME . '?lang=' . $state->lang . '&category=' . $pic->category . '&pic=' . $pic->id . '">', 3);
            $html .= space_br('<img src="' . $thumb . '">', 4);
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

function create_html($state) {
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