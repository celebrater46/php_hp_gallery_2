<?php

$test_url = "test";
$id = $_GET['id'];

require_once("info.php");

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

function xy($array){
    if($array[0] > $array[1]){
        return "x";
    } else {
        return "y";
    }
}

$scale = getimagesize("img/" . $images_array[$id]["src"]);
$class = xy($scale);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="Author" content="Enin Fujimi">
    <title><?php echo $images_array[$id]["title"] ?></title>
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="stylesheet" href="css/gallery.css" type="text/css">
    <link rel="shortcut icon" href="favicon.ico">
</head>
<body>
    <div id="view_bg">
        <a href="#" onclick="window.close(); return false;">
            <img class="art <?php echo $class ?>" src="<?php echo "img/".$images_array[$id]["src"]; ?>">
        </a>

        <div class="txt">
            <h1>ストーカーは犯罪です</h1>
            <h2>やめましょう<?php echo $id; ?></h2>
        </div>

        <div class="back">
            <a href="index.php">- 戻る -</A>
        </div>

        <div class="foot_txt">
            <p>
                Copyright (C) Enin Fujimi All Rights Reserved.
            </p>
            <p>
                <a href="http://enin-world.sakura.ne.jp/" target="_self">
                    http://enin-world.sakura.ne.jp/
                </a>
            </p>
        </div>
</body>
</html>