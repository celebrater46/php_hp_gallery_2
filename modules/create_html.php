<?php

namespace php_hp_gallery\modules;

use php_hp_gallery\classes\Category;
use php_number_link_generator\classes\NumberLink;
use fp_common_modules as cm;

require_once( dirname(__FILE__) . '/../' . PHG_PNLG_DIR . 'init.php');
require_once( dirname(__FILE__) . '/../' . PHG_PNLG_DIR . 'classes/NumberLink.php');
require_once( dirname(__FILE__) . '/../classes/Category.php');
require_once( dirname(__FILE__) . '/../' . PHG_HCM_PATH);

function get_link_to_top($state): string
{
    $html = cm\space_br("<div class='totop'>", 1);
    $html .= cm\space_br("<a href='" . PHG_INDEX_FILE_NAME . "?lang=" . ($state->lang === 1 ? "0" : "1") . "'>", 2);
    $html .= cm\space_br($state->lang === 0 ? "トップへ戻る" : "BACK TO TOP", 3);
    $html .= cm\space_br("</a>", 2);
    $html .= cm\space_br("</div>", 1);
    return $html;
}

function get_lang_links($state): string
{
    $html = cm\space_br("<div class='lang'>", 1);
    $html .= cm\space_br("<a href='" . PHG_INDEX_FILE_NAME . "?lang=" . ($state->lang === 1 ? "0" : "1") . ($state->category === null ? "" : "&category=" . $state->category) . ($state->pic === null ? "" : "&pic=" . $state->pic) . "'>", 2);
    $html .= cm\space_br($state->lang === 1 ? "日本語" : "ENGLISH", 3);
    $html .= cm\space_br("</a>", 2);
    $html .= cm\space_br("</div>", 1);
    return $html;
}

function get_picture_page($picture, $state): string
{
    $img = PHG_IMAGES_DIR_HTTP . "/" . $picture->file_name;
    $html = cm\space_br("<div>", 1);
    $html .= cm\space_br("<a href='" . PHG_INDEX_FILE_NAME . "?lang=" . $state->lang . "'>", 2);
    if(file_exists($img)){
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
    $html .= cm\space_br("<div class='back'>", 1);
    $html .= cm\space_br("<a href='" . PHG_INDEX_FILE_NAME . "?lang=" . $state->lang . "'>" . ($state->lang === 1 ? "BACK" : "戻る") . "</a>", 2);
    $html .= cm\space_br("</div>", 1);
    return $html;
}

function get_thumb_div($pic, $state){
    $thumb = PHG_THUMBNAIL_DIR_HTTP . "/" . $pic->thumb;
    if(file_exists($thumb)){
        $html = cm\space_br("<div class='thumb box'>", 2);
        $html .= cm\space_br('<a href="' . PHG_INDEX_FILE_NAME . '?lang=' . $state->lang . '&category=' . $pic->category . '&pic=' . $pic->id . '">', 3);
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
        } else if($state->category === null){
            break;
        }
    }
    return $html;
}

function get_category_div($category, $state): string
{
    $pic_nums = count($category->pictures);
    $link = new NumberLink($pic_nums);
    $html = cm\space_br("<h2>" . $category->name[$state->lang] . "</h2>", 1);
    $html .= cm\space_br("<div class='thumbs'>", 1);
    $html .= get_thumbs_html($link, $category->pictures, $state);
    $html .= cm\space_br("</div>", 1);
    if(PHG_THUMBNAILS_PER_CATEGORY < $pic_nums
    && $state->category === null)
    {
        $html .= cm\space_br("<div class='seemore'>", 1);
        $html .= cm\space_br('<p><a href="' . PHG_INDEX_FILE_NAME . '?lang=' . $state->lang . '&category=' . $category->id . '&page=1' . '">' . ($state->lang === 1 ? 'See More...' : 'もっと見る') . '</a></p>', 2);
        $html .= cm\space_br("</div>", 1);
    }
    if(PHG_THUMBNAILS_PER_PAGE < $pic_nums
    && $state->category !== null)
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
    if($state->pic === null){
        if(isset(PHG_SITE_NAME[$state->lang])){
            $html .= cm\space_br("<h1>" . PHG_SITE_NAME[$state->lang] . "</h1>", 1);
        }
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
    if($state->category !== null){
        $html .= get_link_to_top($state);
    }
    $html .= get_lang_links($state);
    return $html;
}