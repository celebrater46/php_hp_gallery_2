<?php

//$test_url = 1;
//$max_thumb = 16;

ini_set('display_errors', 1); // エラーメッセージを常時表示する
define('MAX_FILE_SIZE', 1 * 1024 * 1024); // 1MB
define('THUMBNAIL_SIZE', 400);
define('IMAGES_DIR', __DIR__ . '/img'); // 画像ファイルのディレクトリ（__DIR__ は現在のディレクトリ取得）
define('THUMBNAIL_DIR', __DIR__ . '/thumb'); // サムネイルディレクトリ

require_once "info.php";
require_once "Picture.php";

// 画像処理に必要なプラグイン GD の有無
if (!function_exists('imagecreatetruecolor')) {
    echo "Not found GD.";
    exit;
}

//$count = count($images_array);
//$thumb_size = 400;
$lang = 0;
$setting = get_setting();
$list = get_list($setting);
$pictures = get_pictures($list, $lang);
//check_thumb($list, $pictures); // サムネが存在するかチェックし、なければ生成する

//function check_thumb($list, $pictures){
//    if($list === null){
//        return null;
//    } elseif($pictures === null){
//        return null;
//    } else {
//        foreach ($pictures as $picture){
//            $img = check_img($picture->filename);
//            if($img === null){
//                // 元の画像がない場合、404 画像割当
//                $picture->rename_file_404();
//            } else {
//                // サムネが存在しない場合、自動生成
//                if(file_exists("thumb/" . $img) === false){
//                    create_thumb($img);
//                }
//            }
//        }
//    }
//}
//
//function create_thumb($file){
//    $src = "img/" . $file;
//    $to = "thumb/" . $file;
//    $size = getimagesize($src); // [0] => x, [1] => y
//    $width = $size[0];
//    $height = $size[1];
////    $img_type = $width > $height ? "x" : "y"; // 横長なら x 縦長なら y
//    $thumb = calc_thumb_size($width, $height);
//
//    // コピー先リソース、コピー元リソース、コピー先のX座標、同Y座標、コピー元のX座標、Y座興、コピー先の幅、高さ、コピー元の幅、高さ
//    imagecopyresampled($to, $src, 0, 0, 0, 0, $thumb["x"], $thumb["y"], $width, $height);
//}
// 1200 800
//function calc_thumb_size($x, $y){
//    $thumb_size = 400;
//    $array = ["x" => 0, "y" => 0];
//    if($x > $y){
//        $array["y"] = $thumb_size;
//        $array["x"] = round($x / $y * $thumb_size);
//    } else {
//        $array["x"] = $thumb_size;
//        $array["y"] = round($y / $x * $thumb_size);
//    }
//    return $array;
//}

//function check_img($file){
//    $dir = "img/";
//    if(strpos($file, ".png") === false && strpos($file, ".jpg") === false && strpos($file, ".gif") === false){
//        if(file_exists($dir . $file . ".png")){
//            return $file . ".png";
//        } elseif(file_exists($dir . $file . ".jpg")) {
//            return $file . ".jpg";
//        } elseif(file_exists($dir . $file . ".gif")) {
//            return $file . ".gif";
//        } else {
//            return null;
//        }
//    } else {
//        if(file_exists($dir . $file)){
//            return $file;
//        } else {
//            return null;
//        }
//    }
//}

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
//            return ["ERROR:", 'list.txt が見つかりません。Not found "list.txt".'];
            return null;
        }
    }
}

//function get_img_file_names($list_line){
//    if($list_line === "no_list_mode"){
//        return glob("img/*");
//    } else {
//        return null;
//    }
//}

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

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="Author" content="Enin Fujimi">
    <title>PHP HP GALLERY</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/gallery.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>
<body>
    <h1 class="gallery">
        PHP HP GALLERY
    </h1>
    <?php var_dump($pictures); ?>
    <div class="container">
        <?php if($setting === null): ?>
            <p>ERROR: setting.txt が見つかりません。Not found "setting.txt"</p>
        <?php elseif($list === null): ?>
            <p>ERROR: list.txt が見つかりません。Not found "list.txt"</p>
        <?php else: ?>
            <?php if($pictures === null): ?>
                <p>ERROR: 画像読み込みエラー。Loading Error occurred.</p>
            <?php else: ?>
                <?php foreach ($pictures as $picture): ?>
                    <div class="thumb box">
                        <?php if($picture->thumb === null): ?>
                            <img src="404.png">
                        <?php else: ?>
                            <a href="view.php?pic=<?php echo h($picture->id); ?>">
                                <img src="<?php echo $picture->thumb; ?>">
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        <?php endif ?>
    </div>

</body>
</html>