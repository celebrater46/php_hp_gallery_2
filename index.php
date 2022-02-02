<?php

require_once "main.php";
require_once "Picture.php";

$lang = 0;
$pic = isset($_GET["pic"]) ? (int)$_GET["pic"] : null;
$setting = get_setting();
$list = get_list($setting);
$pictures = get_pictures($list, $lang);
//$pic_info =

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
    <div class="container">
        <?php if($setting === null): ?>
            <p>ERROR: setting.txt が見つかりません。Not found "setting.txt"</p>
        <?php elseif($list === null): ?>
            <p>ERROR: list.txt が見つかりません。Not found "list.txt"</p>
        <?php elseif($pic === null): ?>
            <h1 class="gallery">
                PHP HP GALLERY
            </h1>
            <?php if($pictures === null): ?>
                <p>ERROR: 画像読み込みエラー。Loading Error occurred.</p>
            <?php else: ?>
                <div class="thumbs">
                    <?php foreach ($pictures as $picture): ?>
                        <div class="thumb box">
                            <?php if($picture->thumb === null): ?>
                                <img src="404.png">
                            <?php else: ?>
                                <a href="index.php?pic=<?php echo h($picture->id); ?>">
                                    <img src="<?php echo THUMBNAIL_DIR_HTTP . "/" . $picture->thumb; ?>">
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        <?php else: ?>
            <div>
                <a href="index.php">
                    <img class="gallery pic<?php echo $pictures[$pic]->is_wide ? " x" : ""; ?>" src="<?php echo IMAGES_DIR_HTTP . "/" . $pictures[$pic]->file_name; ?>">
                </a>
            </div>
            <?php if($pictures[$pic]->title !== ""): ?>
                <div class="texts">
                    <h1><?php echo $pictures[$pic]->title; ?></h1>
                    <h2><?php echo $pictures[$pic]->comment; ?></h2>
                </div>
            <?php endif; ?>
            <div class="back">
                <a href="index.php">- 戻る -</A>
            </div>
        <?php endif ?>
    </div>

</body>
</html>