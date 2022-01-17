<?php

$test_url = "test";

// hoge.png, "title", "title_en", "description", "description_en"
$images_array = [
    [
        "201223-sally4c.png",
        "Merry X'mas",
        "Merry X'mas",
        "小説「白金記」よりサリーさんがクリスマスプレゼントを持ってきてくれたようです。",
        "Sally might give you a certain gift as X'mas present."
    ],
    [
        "201230-sarma-color-t.png",
        "Happy New Year 2021",
        "Happy New Year 2021",
        "小説「第三世界収容所」より、罰の天使サーマさんです。",
        'Her name is "Sarma". She is the angel of punishment in my novel "The 3rd Prison".'
    ],
    [
        "210804-hizuruSeifukuRedC.jpg",
        "ヒヅル様がセーラー服姿を披露されたようです",
        "That suits Hizuru-sama",
        "年甲斐もなk……おっと、誰か来たようだ。",
        'Hizuru-sama is wearing a sailor suit. Praise her.'
    ],
];

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="Author" content="Enin Fujimi - 富士見永人">
    <title>Dark Labyrinth Gallery</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>
        <a href="/?t=<?php echo h($test_url); ?>">
            Dark Labyrinth Gallery
        </a>
    </h1>
    <div class="container">
        <?php foreach ($images_array as $item) : ?>
            <div class="thumb_box">
                <img src="<?php echo "img/".$item[0]; ?>">
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>