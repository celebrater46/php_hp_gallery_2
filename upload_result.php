<?php

use php_hp_gallery\classes\PhgSetter;
use image_uploader as iu;

require_once "init.php";
require_once "classes/PhgSetter.php";
require_once PHG_IU_DIR . "iu_get_html.php";
require_once PHG_IU_DIR . "ImgUploader.php";

echo "Hello World" . "<br>";

$uploader = iu\iu_get_html("", false);
//var_dump($uploader);

$image = $uploader->_imageFileName;
$setter = new PhgSetter($image);
//var_dump($setter);
$line = $setter->get_line();
$txt = "images.txt";
if(file_exists($txt)){
    error_log((check_final_br($txt) ? "" : "\n") . $line . "\n", 3, $txt);
    echo "Posted '" . $image . "' successfully." . "<br>";
    echo "Updated the list: " . $line . "' successfully." . "<br>";
//    echo '<img src="thumb/' . $image . '">' . "<br>";
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
//    echo "substr: ";
//    var_dump(substr($lines[$key], -2));
    if(substr($lines[$key], -1) === "\n"
        || substr($lines[$key], -1) === "\r"
        || substr($lines[$key], -1) === "\r\n"
        || $lines[$key] === "")
    {
        echo "The final char is BR" . "<br>";
        return true;
    } else {
        echo "The final char is NOT BR" . "<br>";
        return false;
    }
}