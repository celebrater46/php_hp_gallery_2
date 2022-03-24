<?php

namespace php_hp_gallery\modules;

function space_br($html, $num){
    $space = str_repeat("    ", $num);
    return $space . $html . "\n";
}

function delete_br($line){
    return str_replace(["\n", "\r", "\r\n"], "", $line);
}

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}