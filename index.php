<?php

require_once "module.php";
require_once "Picture.php";

$lang = 0;
$setting = get_setting();
$list = get_list($setting);
$pictures = get_pictures($list, $lang);

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
                            <a href="index.php?pic=<?php echo h($picture->id); ?>">
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