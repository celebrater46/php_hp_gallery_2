<?php

namespace php_hp_gallery\modules;

use fp_common_modules as cm;

require_once dirname(__FILE__) . '/../init.php';
require_once dirname(__FILE__) . '/../classes/Picture.php';
//require_once "html_common_module.php";
require_once PHG_HCM_PATH;

// 画像処理に必要なプラグイン GD の有無
if (!function_exists('imagecreatetruecolor')) {
    echo "GD が見つかりません。Not found GD.";
    exit;
}

function get_list($txt){
    if(file_exists($txt)){
        $array = file($txt);
        $new_array = [];
        foreach ($array as $line){
            array_push($new_array, cm\delete_br($line));
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

