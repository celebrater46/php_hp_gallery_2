<?php

namespace php_hp_gallery;

use php_hp_gallery\modules as modules;
use php_hp_gallery\classes\State;

require_once "modules/main.php";
require_once "classes/Picture.php";

$state = new State();

//$lang = isset($_GET["lang"]) ? (int)$_GET["lang"] : 0;
//$pic = isset($_GET["pic"]) ? (int)$_GET["pic"] : null;
//$setting = modules\get_setting();
//$list = modules\get_list($setting);
//$pictures = modules\get_pictures($list, $lang);

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
<?php echo modules\phg_get_html($state); ?>
</div>
</body>
</html>