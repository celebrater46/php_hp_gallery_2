<?php

namespace php_hp_gallery;

use php_hp_gallery\modules as modules;

require_once "modules/create_html.php";

function phg_get_html($state) {
    return modules\create_html($state);
}