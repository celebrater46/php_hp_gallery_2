<?php

namespace php_hp_gallery;

use image_uploader as iu;

require_once "init.php";
require_once "classes/PhgSetter.php";
require_once PHG_IU_DIR . "iu_get_html.php";

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
    <link rel="stylesheet" href="css/phg.css" type="text/css">
</head>
<body>
<div class="container uploader">
    <h1>Upload Pictures</h1>
    <form action="upload_result.php" method="post" enctype="multipart/form-data" id="my-form">
        <?php echo iu\iu_get_html(get_contents_in_form(), true); ?>
    </form>
</div>
</body>
</html>