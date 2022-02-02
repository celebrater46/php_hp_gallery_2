<?php

class Picture
{
    public $id;
    public $file_name;
    public $thumb;
    public $title;
    public $comment;
    public $is_wide;

    function __construct($id, $line, $lang){
        $temp_array = explode("|", $line);
        $this->id = $id;
        $this->file_name = $this->check_img($temp_array[0]);
        $this->thumb = $this->check_thumb();
        $this->title = $this->get_name($temp_array, $lang);
        $this->comment = $this->get_comment($temp_array, $lang);
        $this->is_wide = $this->wide_or_not();
//        throw new Exception("サムネあるのにサムネ作ったったーｗ");
    }

    function get_name($array, $lang){
        if(!(isset($array[1]))){
            return "";
        }
        if($lang !== 1){
            return $array[1];
        } else {
            if(isset($array[3])){
                return $array[3];
            } else{
                return "";
            }
        }
    }

    function get_comment($array, $lang){
        if(!(isset($array[2]))){
            return "";
        }
        if($lang !== 1){
            return $array[2];
        } else {
            if(isset($array[4])){
                return $array[4];
            } else{
                return "";
            }
        }
    }

    function check_img($file){
        $img = IMAGES_DIR . "/" . $file;
        if(strpos($img, ".png") === false && strpos($img, ".jpg") === false && strpos($img, ".gif") === false){
            if(file_exists($img . ".png")){
                return $file . ".png";
            } elseif(file_exists($img . ".jpg")) {
                return $file . ".jpg";
            } elseif(file_exists($img . ".gif")) {
                return $file . ".gif";
            } else {
                return null;
            }
        } else {
            if(file_exists($img)){
//                $temp = str_replace(IMAGES_DIR, "", $img);
                return $file;
            } else {
                return null;
            }
        }
    }

    function wide_or_not(){
        $src = IMAGES_DIR . "/" . $this->file_name;
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
            if(file_exists("thumb/" . $this->file_name) === false){
                $this->create_thumb($this->file_name);
            }
            return $this->file_name;
        }
    }

    function create_thumb($file){
        $src = IMAGES_DIR . "/" . $file;
        $to = THUMBNAIL_DIR . "/" . $file;
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
                imagegif($created_img, THUMBNAIL_DIR . "/" . $file);
                break;
            case "jpg":
            case "jpeg":
                imagejpeg($created_img, THUMBNAIL_DIR . "/" . $file);
                break;
            case "png":
                imagepng($created_img, THUMBNAIL_DIR . "/" . $file);
                break;
        }
    }

    function calc_thumb_size($x, $y){
        $array = ["x" => 0, "y" => 0];
        if($x > $y){
            $array["y"] = THUMBNAIL_SIZE;
            $array["x"] = round($x / $y * THUMBNAIL_SIZE);
        } else {
            $array["x"] = THUMBNAIL_SIZE;
            $array["y"] = round($y / $x * THUMBNAIL_SIZE);
        }
        return $array;
    }
}