<?php

//ini_set('display_errors', 1); // エラーメッセージを常時表示する
define('THUMBNAIL_SIZE', 400); // 自動生成されるサムネのサイズ（実際に表示されるのは CSS の div.thumb.box のサイズ）
define('IMAGES_DIR', __DIR__ . '/img'); // 画像ファイルのディレクトリ（__DIR__ は現在のディレクトリ取得）
define('THUMBNAIL_DIR', __DIR__ . '/thumb'); // サムネイルディレクトリ
define('IMAGES_DIR_HTTP', 'img'); // HTTPでアクセスした際にディレクトリが変わるので用意
define('THUMBNAIL_DIR_HTTP', 'thumb');