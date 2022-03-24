<?php

namespace php_hp_gallery;

//use php_hp_gallery\modules as modules;
use php_hp_gallery\classes\State;

require_once "modules/main.php";
require_once "phg_get_html.php";
require_once "classes/Picture.php";
require_once "classes/State.php";

$state = new State();


?>
<!DOCTYPE html>
<html lang="<?php echo $state->lang === 1 ? 'en' : 'ja'; ?>">
<head>
    <meta charset="utf-8">
    <meta name="Author" content="<?php echo PHG_AUTHOR; ?>">
    <title><?php echo PHG_SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/gallery.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>
<body>
<div class="container">
<?php echo phg_get_html($state); ?>
</div>
</body>
</html>