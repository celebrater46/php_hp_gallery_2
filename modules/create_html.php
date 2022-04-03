<?php

namespace php_hp_gallery\modules;

use php_hp_gallery\classes\Category;
//use php_hp_gallery\classes\State;
use php_number_link_generator\classes\NumberLink;
use fp_common_modules as cm;

require_once PHG_PNLG_DIR . 'init.php';
require_once PHG_PNLG_DIR . 'classes/NumberLink.php';
require_once dirname(__FILE__) . '/../classes/Category.php';
require_once PHG_HCM_PATH;

function get_link_to_top($state): string
{
    $html = cm\space_br("<div class='totop'>", 1);
    $html .= cm\space_br("<a href='" . PHG_INDEX . "?lang=" . ($state->lang === 1 ? "0" : "1") . "'>", 2);
    $html .= cm\space_br($state->lang === 0 ? "トップへ戻る" : "BACK TO TOP", 3);
    $html .= cm\space_br("</a>", 2);
    $html .= cm\space_br("</div>", 1);
    return $html;
}

function get_lang_links($state): string
{
    $html = cm\space_br("<div class='lang'>", 1);
    $html .= cm\space_br("<a href='" . PHG_INDEX . "?lang=" . ($state->lang === 1 ? "0" : "1") . ($state->category === -1 ? "" : "&category=" . $state->category) . ($state->pic === -1 ? "" : "&pic=" . $state->pic) . "'>", 2);
    $html .= cm\space_br($state->lang === 1 ? "日本語" : "ENGLISH", 3);
    $html .= cm\space_br("</a>", 2);
    $html .= cm\space_br("</div>", 1);
    return $html;
}

function get_prev_arrow($state){
    $html = cm\space_br("<div class='prev'>", 2);
    if($state->pic > 0){
        $html .= cm\space_br("<a href='" . PHG_INDEX . $state->get_url_parameters("pic", -1) . "'>＜＜</a>", 3);
    } else {
        $html .= cm\space_br("　 ", 3);
    }
    $html .= cm\space_br("</div>", 2);
    return $html;
}

function get_next_arrow($category, $state){
    $html = cm\space_br("<div class='next'>", 2);
    if($state->pic < count($category->pictures) - 1){
        $html .= cm\space_br("<a href='" . PHG_INDEX . $state->get_url_parameters("pic", 1) . "'>＞＞</a>", 3);
    } else {
        $html .= cm\space_br("　 ", 3);
    }
    $html .= cm\space_br("</div>", 2);
    return $html;
}

function get_picture_page($category, $state): string
{
//    var_dump($category);
    $picture = $category->pictures[$state->pic];
    $img = PHG_IMAGES_HTTP_PATH . $picture->file_name;
//    var_dump($img);
    $html = cm\space_br("<div>", 1);
    $html .= cm\space_br("<a href='" . PHG_INDEX . "?lang=" . $state->lang . "'>", 2);
    $res = @file_get_contents($img);
//    var_dump($thumb);
//    if(file_exists($thumb)){
//    if(file_exists($img)){
    if ($res !== false) {
        $html .= cm\space_br('<img class="gallery pic' . ($picture->is_wide ? " x" : "") . '" src="' . $img . '">', 3);
    } else {
        echo "NOT FOUND: " . $picture->file_name . "<br>";
    }
    $html .= cm\space_br("</a>", 2);
    $html .= cm\space_br("</div>", 1);
    if($picture->title !== ""){
        $html .= cm\space_br("<div class='texts'>", 1);
        $html .= cm\space_br("<h1>" . $picture->title . "</h1>", 2);
        $html .= cm\space_br("<h2>" . $picture->comment . "</h2>", 2);
        $html .= cm\space_br("</div>", 1);
    }
    $html .= cm\space_br("<div class='phg_links'>", 1);
    $html .= get_prev_arrow($state);
    $html .= cm\space_br("<div class='back'>", 2);
    $html .= cm\space_br("<a href='" . PHG_INDEX . $state->get_url_parameters("", 0) . "'>" . ($state->lang === 1 ? "BACK" : "戻る") . "</a>", 3);
    $html .= cm\space_br("</div>", 2);
    $html .= get_next_arrow($category, $state);
    $html .= cm\space_br("</div>", 1);
    return $html;
}

function get_thumb_div($pic, $state){
    $thumb = PHG_THUMBNAIL_HTTP_PATH . $pic->thumb;
    $res = @file_get_contents($thumb);
//    var_dump($thumb);
//    if(file_exists($thumb)){
    if ($res !== false) {
        $html = cm\space_br("<div class='thumb box'>", 2);
        $html .= cm\space_br('<a href="' . PHG_INDEX . '?lang=' . $state->lang . '&category=' . $pic->category . '&pic=' . $pic->id . '">', 3);
        $html .= cm\space_br('<img src="' . $thumb . '">', 4);
        $html .= cm\space_br('</a>', 3);
        $html .= cm\space_br("</div>", 2);
        return $html;
    } else {
        echo "NOT FOUND: " . $pic->thumb . "<br>";
    }
}

function get_thumbs_html($link, $pics, $state){
    $html = "";
    for($i = $link->start; $i < $link->start + PNLG_MAX_TEXT_NUM; $i++){
        if($i < $link->end && isset($pics[$i])){
            $html .= get_thumb_div($pics[$i], $state);
        } else if($state->category === -1){
            break;
        }
    }
    return $html;
}

function get_category_div($category, $state): string
{
    $pic_nums = count($category->pictures);
    $link = new NumberLink($pic_nums, PHG_THUMBNAILS_PER_PAGE);
    $html = cm\space_br("<h2>" . $category->name[$state->lang] . "</h2>", 1);
    $html .= cm\space_br("<div class='thumbs'>", 1);
    $html .= get_thumbs_html($link, $category->pictures, $state);
    $html .= cm\space_br("</div>", 1);
    if(PHG_THUMBNAILS_PER_CATEGORY < $pic_nums
    && $state->category === -1)
    {
        $html .= cm\space_br("<div class='seemore'>", 1);
        $html .= cm\space_br('<p><a href="' . PHG_INDEX . '?lang=' . $state->lang . '&category=' . $category->id . '&page=1' . '">' . ($state->lang === 1 ? 'See More...' : 'もっと見る') . '</a></p>', 2);
        $html .= cm\space_br("</div>", 1);
    }
    if(PHG_THUMBNAILS_PER_PAGE < $pic_nums
    && $state->category !== -1)
    {
        $parameters = "&lang=" . $state->lang . "&category=" . $state->category;
        $html .= $link->get_page_links_html($parameters);
    }
    return $html;
}

function get_categories($state): array
{
    $categories_lines = get_list("categories.txt");
    $array = [];
    foreach ($categories_lines as $line){
        array_push($array, new Category($line, $state));
    }
    return $array;
}

function create_html($state): string
{
    $categories = get_categories($state);
    $html = "";
    if($state->pic === -1){
        if(isset(PHG_SITE_NAME[$state->lang])){
            $html .= cm\space_br("<h1>" . PHG_SITE_NAME[$state->lang] . "</h1>", 1);
        }
        if($state->category === -1){
            foreach ($categories as $category){
                $html .= get_category_div($category, $state);
            }
        } else {
            $html .= get_category_div($categories[$state->category], $state);
        }
    } else {
        $html = get_picture_page($categories[$state->category], $state);
    }
    if($state->category !== -1){
        $html .= get_link_to_top($state);
    }
    $html .= get_lang_links($state);
    return $html;
}