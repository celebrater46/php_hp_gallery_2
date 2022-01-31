<?php

require_once "Picture.php";

ini_set('display_errors', 1); // エラーメッセージを常時表示する
define('MAX_FILE_SIZE', 1 * 1024 * 1024); // 1MB
define('THUMBNAIL_SIZE', 400);
define('IMAGES_DIR', __DIR__ . '/img'); // 画像ファイルのディレクトリ（__DIR__ は現在のディレクトリ取得）
define('THUMBNAIL_DIR', __DIR__ . '/thumb'); // サムネイルディレクトリ
define('IMAGES_DIR_HTTP', 'img'); // HTTPでアクセスした際にディレクトリが変わるので用意
define('THUMBNAIL_DIR_HTTP', 'thumb');

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

function get_list($setting){
    // title_and_comment
    if($setting === null){
        return null;
    }
    if(file_exists("list.txt")){
        return file("list.txt");
    } else {
        if($setting[1] === "false"){
            return ["no_list_mode"];
        } else {
            return null;
        }
    }
}

function get_setting(){
    if(file_exists("setting.txt")){
        $setting = file("setting.txt");
        $array = [];
        foreach ($setting as $line){
            array_push($array, str_replace(["multi_language:", "title_and_comment:", " ", "\r", "\n", "\r\n"], "", $line));
        }
        return $array;
    } else {
        return null;
    }
}

//function get_info($pic){
//
//}

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}