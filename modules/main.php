<?php

namespace php_hp_gallery\modules;
use php_hp_gallery\classes\Picture;

//require_once "Picture.php";
require_once ( dirname(__FILE__) . '/../init.php');
require_once( dirname(__FILE__) . '/../classes/Picture.php');
require_once "html_common_module.php";

// 画像処理に必要なプラグイン GD の有無
if (!function_exists('imagecreatetruecolor')) {
    echo "GD が見つかりません。Not found GD.";
    exit;
}

function get_pictures($list, $lang){
    if($list[0] === "no_list_mode"){
        $file_names = glob("img/*");
        $array = [];
        $i = 0;
        foreach ($file_names as $file){
            $temp = str_replace("img/", "", $file);
            array_push($array, new Picture($i, $temp . "|無題|コメントは特にありません。|UNKNOWN|No comment.", $lang));
            $i++;
        }
        return $array;
    } elseif ($list === null) {
        return null;
    } else {
        $array = [];
        $i = 0;
        foreach ($list as $line){
            $temp = str_replace(["\r", "\n", "\r\n"], "", $line);
            array_push($array, new Picture($i, $temp, $lang));
            $i++;
        }
        return $array;
    }
}

function get_list($txt){
    if(file_exists($txt)){
        $array = file($txt);
        $new_array = [];
        foreach ($array as $line){
            array_push($new_array, delete_br($line));
        }
        return $array;
    } else {
        if($txt === "images.txt" && PHG_TITLE_AND_COMMENT === false){
            echo "No list mode" . "<br>";
            return null;
        } else {
            echo "NOT FOUND: " . $txt . "<br>";
            return null;
        }
    }
}

//function get_images_txt(){
//    // title_and_comment
////    if($setting === null){
////        return null;
////    }
//    if(file_exists("images.txt")){
//        $array = file("images.txt");
//        $new_array = [];
//        foreach ($array as $line){
//            array_push($new_array, delete_br($line));
//        }
//        return $array;
////        return file("images.txt");
//    } else {
//        if(PHG_TITLE_AND_COMMENT === false){
//            echo "No list mode" . "<br>";
//            return null;
//        } else {
//            echo "NOT FOUND: images.txt" . "<br>";
//            return null;
//        }
//    }
//}
//
//function get_categories_txt(){
//    if(file_exists("categories.txt")){
//        $array = file("categories.txt");
//        $new_array = [];
//        foreach ($array as $line){
//            array_push($new_array, delete_br($line));
//        }
//        return $array;
////        return file("images.txt");
//    } else {
//        if(PHG_TITLE_AND_COMMENT === false){
//            echo "No list mode" . "<br>";
//            return null;
//        } else {
//            echo "NOT FOUND: images.txt" . "<br>";
//            return null;
//        }
//    }
//}

//function get_setting(){
//    if(file_exists("setting.txt")){
//        $setting = file("setting.txt");
//        $array = [];
//        foreach ($setting as $line){
//            array_push($array, str_replace(["multi_language:", "title_and_comment:", "title:", "\r", "\n", "\r\n"], "", $line));
//        }
//        $array[2] = explode("|", $array[2]); // 日本語タイトル, english_title
//        return $array;
//    } else {
//        return null;
//    }
//}
