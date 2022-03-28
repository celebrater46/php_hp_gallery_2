<?php

use php_hp_gallery\classes\PhgSetter;
use image_uploader as iu;

require_once "init.php";
require_once "classes/PhgSetter.php";
require_once PHG_IU_DIR . "iu_get_html.php";
require_once PHG_IU_DIR . "ImgUploader.php";

echo "Hello World" . "<br>";

$uploader = iu\iu_get_html("", false);
var_dump($uploader);

$image = $uploader->_imageFileName;
$setter = new PhgSetter($image);
var_dump($setter);
$line = $setter->get_line();
$txt = "images.txt";
if(file_exists($txt)){
    error_log((check_final_br($txt) ? "\n" : "") . $line . "\n", 3, $txt);
    echo "Post '" . $image . "' Succeeded: " . $line;
    echo '<img src="thumb/' . $image . '">';
} else {
    echo "NOT FOUND: " . $txt;
}

//if ($_SERVER["REQUEST_METHOD"] === "POST") { // 定義済み変数。投稿、送信が行われたらの処理
////    $uploader["obj"]->upload();
//
//}

function check_final_br($txt){
    $lines = file($txt);
    $key = array_key_last($lines);
    if(substr($lines[$key], -2) === "\n"
        || substr($lines[$key], -2) === "\r"
        || substr($lines[$key], -4) === "\r\n")
    {
        return true;
    } else {
        return false;
    }
}