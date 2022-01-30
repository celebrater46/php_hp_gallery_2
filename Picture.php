<?php

class Picture
{
    public $id;
    public $dir;
    public $file_name;
    public $thumb;
    public $title;
    public $comment;

    function __construct($id, $line, $lang){
        $temp_array = explode("|", $line);
        $this->dir = "img/";
        $this->id = $id;
        $this->file_name = $this->check_img($temp_array[0]);
        $this->thumb = $this->check_thumb();
        $this->title = $this->get_name($temp_array, $lang);
        $this->comment = $this->get_comment($temp_array, $lang);
    }

//    function rename_file_404(){
//        $this->file_name = "../404.png";
//    }

    function get_name($array, $lang){
        if(!(isset($array[1]))){
            return "無題";
        }
        if($lang !== 1){
            return $array[1];
        } else {
            if(isset($array[3])){
                return $array[3];
            } else{
                return "UNKNOWN";
            }
        }
    }

    function get_comment($array, $lang){
        if(!(isset($array[2]))){
            return "コメントは特にありません。";
        }
        if($lang !== 1){
            return $array[2];
        } else {
            if(isset($array[4])){
                return $array[4];
            } else{
                return "No comment.";
            }
        }
    }

    function check_img($file){
        $img = $this->dir . $file;
        if(strpos($img, ".png") === false && strpos($img, ".jpg") === false && strpos($img, ".gif") === false){
            if(file_exists($img . ".png")){
                return $file . ".png";
            } elseif(file_exists($img . ".jpg")) {
                return $file . ".jpg";
            } elseif(file_exists($img . ".gif")) {
                return $file . ".gif";
            } else {
//                return "../404.png";
                return null;
            }
        } else {
            if(file_exists($img)){
                $temp = str_replace($this->dir, "", $img);
                return $temp;
            } else {
//                return "../404.png";
                return null;
            }
        }
    }

    function check_thumb(){
        if($this->file_name === null){
            $this->thumb = null;
        } else {
            if(file_exists("thumb/" . $this->file_name) === false){
                $this->create_thumb($this->file_name);
            }
            return "thumb/" . $this->file_name;
        }
//        if($list === null){
//            return null;
//        } elseif($pictures === null){
//            return null;
//        } else {
//            foreach ($pictures as $picture){
//                $img = $this->check_img($this->file_name);
//                if($img === null){
//                    // 元の画像がない場合、404 画像割当
//                    $this->rename_file_404();
//                } else {
//                    // サムネが存在しない場合、自動生成
//                    if(file_exists("thumb/" . $img) === false){
//                        create_thumb($img);
//                        return "thumb/" . $img;
//                    }
//                }
//            }
//        }
    }

    function create_thumb($file){
        $src = IMAGES_DIR . "/" . $file;
        $to = THUMBNAIL_DIR . "/" . $file;
        var_dump($src);
//        var_dump($to);
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
//        try{
//
//        } catch (Exception $e){
//            $_SESSION["error"] = $e->getMessage();
//        }
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
//        $thumb_size = 400;
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