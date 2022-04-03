<?php

namespace php_hp_gallery;

use php_hp_gallery\modules as modules;
use php_hp_gallery\classes\State;

require_once "modules/main.php";
require_once "modules/create_html.php";
require_once "phg_get_html.php";
require_once "classes/Picture.php";
require_once "classes/State.php";

$state = new State();


?>
<!DOCTYPE html>
<html lang="<?php echo $state->lang === 1 ? 'en' : 'ja'; ?>">
<head>
    <meta charset="utf-8">
    <meta name="Author" content="<?php echo PHG_AUTHOR[$state->lang]; ?>">
    <title><?php echo PHG_SITE_NAME[$state->lang]; ?></title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/phg.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>
<body>
<div class="container">
<?php echo phg_get_html($state); ?>
<?php echo modules\get_lang_links($state); ?>
</div>
</body>
</html>