<?php

namespace php_hp_gallery\modules;

require_once ( dirname(__FILE__) . '/../init.php');
require_once( dirname(__FILE__) . '/../classes/Picture.php');
require_once "html_common_module.php";

// 画像処理に必要なプラグイン GD の有無
if (!function_exists('imagecreatetruecolor')) {
    echo "GD が見つかりません。Not found GD.";
    exit;
}

//function get_pictures($list, $lang){
//    if($list[0] === "no_list_mode"){
//        $file_names = glob("img/*");
//        $array = [];
//        $i = 0;
//        foreach ($file_names as $file){
//            $temp = str_replace("img/", "", $file);
//            array_push($array, new Picture($i, $temp . "|無題|コメントは特にありません。|UNKNOWN|No comment.", $lang));
//            $i++;
//        }
//        return $array;
//    } elseif ($list === null) {
//        return null;
//    } else {
//        $array = [];
//        $i = 0;
//        foreach ($list as $line){
//            $temp = str_replace(["\r", "\n", "\r\n"], "", $line);
//            array_push($array, new Picture($i, $temp, $lang));
//            $i++;
//        }
//        return $array;
//    }
//}

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

