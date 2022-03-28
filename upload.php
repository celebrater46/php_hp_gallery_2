<?php

namespace php_hp_gallery;

use image_uploader as iu;

require_once "init.php";
require_once PHG_IU_DIR . "iu_get_html.php";

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
    <form action="upload_result.php" method="post">
        <label for="category">カテゴリ(整数): </label>
        <input class="text" type="text" id="category" name="category" size="3"/>　
        <label for="title_jp">タイトル: </label>
        <input class="text" type="text" id="title_jp" name="title_jp" size="15"/>
        <br>
        <br>
        <label for="comment_jp">コメント: </label>
        <br>
        <textarea id="comment_jp" name="comment_jp" style="width: 640px; height: 320px"></textarea>
        <br>
        <br>
        <!--    <input type="text" id="path" name="path" size="3"/>-->
        <!--    <input type="submit" value="Update!"/>-->
        <?php echo iu\iu_get_html("画像ファイル："); ?>
        <br>
        <input class="btn" type="submit" value="送信">
    </form>
</div>
</body>
</html>