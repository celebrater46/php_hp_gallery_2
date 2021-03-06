<?php

namespace php_hp_gallery\classes;

class Picture
{
    public $id;
    public $date;
    public $category;
    public $file_name;
    public $thumb;
    public $title;
    public $comment;
    public $is_wide;

    function __construct($id, $category, $array, $lang){
        $this->id = $id;
//        $this->date = $array[2];
        $this->date = $this->get_date($array[2], $lang);
        $this->category = $category;
        $this->file_name = $this->check_img($array[1]);
        $this->thumb = $this->check_thumb();
        $this->title = $this->get_name($array, $lang);
        $this->comment = $this->get_comment($array, $lang);
        $this->is_wide = $this->wide_or_not();
    }

    function get_date($date, $lang){
        if($date !== "__UNKNOWN__"){
            if(strlen($date) === 7){
                $head = $lang === 1 ? "Publish Date: " : "公開時期： ";
                if($lang === 1){
                    return $head . date('M Y',  strtotime($date));
                } else {
                    return $head . date('Y年n月',  strtotime($date)) . "頃";
                }
            } else if(strlen($date) === 10){
                $head = $lang === 1 ? "Publish Date: " : "公開日： ";
                if($lang === 1){
                    return $head . date('M j Y',  strtotime($date));
                } else {
                    return $head . date('Y年n月j日',  strtotime($date));
                }
            }
        }
        $head = $lang === 1 ? "Publish Date: " : "公開時期： ";
        return $head . ($lang === 1 ? "UNKNOWN" : "不明");
    }

    function get_name($array, $lang){
        if($lang !== 1){
            return $array[3] ?? "";

        } else {
            return $array[4] ?? "";
        }
    }

    function get_comment($array, $lang){
        if($lang !== 1){
            return $array[5] ?? "";
        } else {
            return $array[6] ?? "";
        }
    }

    function check_img($file){
        $img = PHG_IMAGES_DIR . $file;
//        var_dump($img);
        if(strpos($img, ".png") === false && strpos($img, ".jpg") === false && strpos($img, ".gif") === false){
            if(file_exists($img . ".png")){
                return $file . ".png";
            } elseif(file_exists($img . ".jpg")) {
                return $file . ".jpg";
            } elseif(file_exists($img . ".gif")) {
                return $file . ".gif";
            } else {
                echo "NOT FOUND IMG: " . $file . "<br>";
                return null;
            }
        } else {
            if(file_exists($img)){
                return $file;
            } else {
                echo "NOT FOUND IMG: " . $img . "<br>";
                return null;
            }
        }
    }

    function wide_or_not(){
        $src = PHG_IMAGES_DIR . $this->file_name;
//        var_dump($src);
        $size = getimagesize($src); // [0] => x, [1] => y
        if($size[0] > $size[1]){
            return true;
        } else {
            return false;
        }
    }

    function check_thumb(){
        if($this->file_name === null){
            $this->thumb = null;
        } else {
            if(file_exists(PHG_THUMBNAIL_DIR . $this->file_name) === false){
                $this->create_thumb($this->file_name);
            }
            return $this->file_name;
        }
    }

    function create_thumb($file){
        $src = PHG_IMAGES_DIR . $file;
        $to = PHG_THUMBNAIL_DIR . $file;
        $size = getimagesize($src); // [0] => x, [1] => y
        $width = $size[0];
        $height = $size[1];
        $thumb = $this->calc_thumb_size($width, $height);

        switch (substr($file, -3)) {
            case "gif":
                $src_image = imagecreatefromgif($src); // 画像リソースの作成
                break;
            case "jpg":
            case "jpeg":
                $src_image = imagecreatefromjpeg($src); // 画像リソースの作成
                break;
            case "png":
                $src_image = imagecreatefrompng($src); // 画像リソースの作成
                break;
        }
        $created_img = imagecreatetruecolor($thumb["x"], $thumb["y"]);
        // コピー先リソース、コピー元リソース、コピー先のX座標、同Y座標、コピー元のX座標、Y座興、コピー先の幅、高さ、コピー元の幅、高さ
        imagecopyresampled($created_img, $src_image, 0, 0, 0, 0, $thumb["x"], $thumb["y"], $width, $height);
        switch (substr($file, -3)) {
            case "git":
                imagegif($created_img, PHG_THUMBNAIL_DIR . $file);
                break;
            case "jpg":
            case "jpeg":
                imagejpeg($created_img, PHG_THUMBNAIL_DIR . $file);
                break;
            case "png":
                imagepng($created_img, PHG_THUMBNAIL_DIR . $file);
                break;
        }
    }

    function calc_thumb_size($x, $y){
        $array = ["x" => 0, "y" => 0];
        if($x > $y){
            $array["y"] = PHG_THUMBNAIL_SIZE;
            $array["x"] = round($x / $y * PHG_THUMBNAIL_SIZE);
        } else {
            $array["x"] = PHG_THUMBNAIL_SIZE;
            $array["y"] = round($y / $x * PHG_THUMBNAIL_SIZE);
        }
        return $array;
    }
}