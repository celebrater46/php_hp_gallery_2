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
                return $img . ".png";
            } elseif(file_exists($img . ".jpg")) {
                return $img . ".jpg";
            } elseif(file_exists($img . ".gif")) {
                return $img . ".gif";
            } else {
                return "../404.png";
            }
        } else {
            if(file_exists($img)){
                return $img;
            } else {
                return "../404.png";
            }
        }
    }

    function check_thumb(){
        if($this->file_name === "../404.png"){
            $this->thumb = "../404.png";
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
        $src = "img/" . $file;
        $to = "thumb/" . $file;
        $size = getimagesize($src); // [0] => x, [1] => y
        $width = $size[0];
        $height = $size[1];
        $thumb = $this->calc_thumb_size($width, $height);

        // コピー先リソース、コピー元リソース、コピー先のX座標、同Y座標、コピー元のX座標、Y座興、コピー先の幅、高さ、コピー元の幅、高さ
        imagecopyresampled($to, $src, 0, 0, 0, 0, $thumb["x"], $thumb["y"], $width, $height);
    }

    function calc_thumb_size($x, $y){
        $thumb_size = 400;
        $array = ["x" => 0, "y" => 0];
        if($x > $y){
            $array["y"] = $thumb_size;
            $array["x"] = round($x / $y * $thumb_size);
        } else {
            $array["x"] = $thumb_size;
            $array["y"] = round($y / $x * $thumb_size);
        }
        return $array;
    }
}