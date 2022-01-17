<?php

$test_url = 1;
$max_thumb = 16;

require_once("info.php");

$count = count($images_array);

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="Author" content="Enin Fujimi">
    <title>PHP MY GALLERY</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/gallery.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>
<body>
    <h1 class="gallery">
        <a href="/?t=<?php echo h($test_url); ?>">
            PHP MY GALLERY
        </a>
    </h1>
    <div class="container">
        <?php for ($i = 0; $i < $count; $i++) : ?>
            <div class="thumb_box">
                <a href="view.php?id=<?php echo h($i); ?>">
                    <img src="<?php echo "img/".$images_array[$i]["src"]; ?>">
                </a>
            </div>
        <?php endfor; ?>
    </div>

</body>
</html>