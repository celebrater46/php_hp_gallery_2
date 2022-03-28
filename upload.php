<?php

namespace php_hp_gallery;

use image_uploader as iu;
//use php_hp_gallery\classes\PhgSetter;

require_once "init.php";
require_once "classes/PhgSetter.php";
require_once PHG_IU_DIR . "iu_get_html.php";

//$uploader = iu\iu_get_html(get_contents_in_form());

//if ($_SERVER["REQUEST_METHOD"] === "POST") { // 定義済み変数。投稿、送信が行われたらの処理
////    $uploader["obj"]->upload();
//    $setter = new PhgSetter($uploader["obj"]->_imageFileName);
//    var_dump($setter);
//    $line = $setter->get_line();
//    $txt = "images.txt";
//    if(file_exists($txt)){
//        error_log((check_final_br($txt) ? "\n" : "") . $line . "\n", 3, $txt);
//    } else {
//        echo "NOT FOUND: " . $txt;
//    }
//}
//
//function check_final_br($txt){
//    $lines = file($txt);
//    $key = array_key_last($lines);
//    if(substr($lines[$key], -2) === "\n"
//    || substr($lines[$key], -2) === "\r"
//    || substr($lines[$key], -4) === "\r\n")
//    {
//        return true;
//    } else {
//        return false;
//    }
//}

//function save_lists(){
//    $category = isset($_POST["category"]) ? (int)$_POST["category"] : 0;
//    $file_name = isset($_POST["category"]) ? (int)$_POST["category"] : 0;
//}

function get_contents_in_form(){
    return <<<EOT
        <label for="category">カテゴリ(整数): </label>
        <input class="text" type="text" id="category" name="category" size="3"/>　
        <label for="title_jp">タイトル: </label>
        <input class="text" type="text" id="title_jp" name="title_jp" size="15"/>
        <br>
        <br>
        <label for="comment_jp">コメント: </label>
        <textarea id="comment_jp" name="comment_jp" style="width: 640px; height: 120px"></textarea>
        <br>
        <br>
        <label for="title_en">Title(English): </label>
        <input class="text" type="text" id="title_en" name="title_en" size="15"/>
        <br>
        <br>
        <label for="comment_en">Comment(English): </label>
        <textarea id="comment_en" name="comment_en" style="width: 640px; height: 120px"></textarea>
        <br>
        <br>
EOT;

}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Upload Pictures</title>
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="stylesheet" href="css/gallery.css" type="text/css">
</head>
<body>
<div class="container uploader">
    <h1>Upload Pictures</h1>
<!--    <form action="upload_result.php" method="post">-->
    <form action="upload_result.php" method="post" enctype="multipart/form-data" id="my-form">
<!--    <form action="" method="post" enctype="multipart/form-data" id="my-form">-->
        <?php echo iu\iu_get_html(get_contents_in_form(), true); ?>
<!--        <br>-->
<!--        <input class="btn" type="submit" value="送信">-->
    </form>
</div>
</body>
</html>