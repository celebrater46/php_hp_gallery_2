<?php

namespace php_hp_gallery;

use php_hp_gallery\modules as modules;

require_once "modules/main.php";
require_once "classes/Picture.php";

$lang = isset($_GET["lang"]) ? (int)$_GET["lang"] : 0;
$pic = isset($_GET["pic"]) ? (int)$_GET["pic"] : null;
$setting = modules\get_setting();
$list = modules\get_list($setting);
$pictures = modules\get_pictures($list, $lang);

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
            <?php if(isset($setting[2]) && $setting[2] !== ""): ?>
                <h1 class="gallery">
                    <?php echo $lang === 1 ? $setting[2][1] : $setting[2][0]; ?>
                </h1>
            <?php endif; ?>

            <?php if($pictures === null): ?>
                <p>ERROR: 画像読み込みエラー。Loading Error occurred.</p>
            <?php else: ?>
                <div class="thumbs">
                    <?php foreach ($pictures as $picture): ?>
                        <div class="thumb box">
                            <?php if($picture->thumb === null): ?>
                                <img src="404.png">
                            <?php else: ?>
                                <a href="index.php?lang=<?php echo modules\h($lang); ?>&pic=<?php echo modules\h($picture->id); ?>">
                                    <img src="<?php echo THUMBNAIL_DIR_HTTP . "/" . modules\h($picture->thumb); ?>">
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        <?php else: ?>
            <div>
                <a href="index.php?lang=<?php echo modules\h($lang); ?>">
                    <img class="gallery pic<?php echo $pictures[$pic]->is_wide ? " x" : ""; ?>" src="<?php echo IMAGES_DIR_HTTP . "/" . modules\h($pictures[$pic]->file_name); ?>">
                </a>
            </div>
            <?php if($pictures[$pic]->title !== "" && $setting[1] === "true"): ?>
                <div class="texts">
                    <h1><?php echo modules\h($pictures[$pic]->title); ?></h1>
                    <h2><?php echo modules\h($pictures[$pic]->comment); ?></h2>
                </div>
            <?php endif; ?>
            <div class="back">
                <a href="index.php?lang=<?php echo modules\h($lang); ?>">- <?php echo $lang === 1 ? "BACK" : "戻る"; ?> -</A>
            </div>
        <?php endif ?>

        <?php if($setting[0] === "true"): ?>
            <div class="lang">
                <?php if($lang === 1): ?>
                    <a href="index.php?lang=0<?php echo $pic === null ? "" : "&pic=" . modules\h($pic); ?>">日本語</a>
                <?php else: ?>
                    <a href="index.php?lang=1<?php echo $pic === null ? "" : "&pic=" . modules\h($pic); ?>">ENGLISH</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>