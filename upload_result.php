<?php

use php_hp_gallery\classes\PhgSetter;
use image_uploader as iu;

require_once "init.php";
require_once "classes/PhgSetter.php";
require_once PHG_IU_DIR . "iu_get_html.php";
require_once PHG_IU_DIR . "ImgUploader.php";

$uploader = iu\iu_get_html("", false);

$image = $uploader->_imageFileName;
$setter = new PhgSetter($image);
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

function check_final_br($txt){
    $lines = file($txt);
    $key = array_key_last($lines);
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