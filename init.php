<?php

namespace php_hp_gallery;

//ini_set('display_errors', 1); // エラーメッセージを常時表示する
define('PHG_THUMBNAIL_SIZE', 400); // 自動生成されるサムネのサイズ（実際に表示されるのは CSS の div.thumb.box のサイズ）
define('PHG_THUMBNAILS_PER_CATEGORY', 1); // 全カテゴリ表示モードの時に1カテゴリあたり何行までサムネイルを表示するか
define('PHG_IMAGES_DIR', __DIR__ . '/img'); // 画像ファイルのディレクトリ（__DIR__ は現在のディレクトリ取得）
define('PHG_THUMBNAIL_DIR', __DIR__ . '/thumb'); // サムネイルディレクトリ
define('PHG_IMAGES_DIR_HTTP', 'img'); // HTTPでアクセスした際にディレクトリが変わるので用意
define('PHG_THUMBNAIL_DIR_HTTP', 'thumb');
//define('PHG_THUMBNAIL_DIR_HTTP', 'http://localhost/myapps/php_hp_gallery/thumb');
define('PHG_MULTI_LANGUAGE', true); // 日本語と英語の二ヶ国語表示にするか
define('PHG_TITLE_AND_COMMENT', true); // 画像のタイトルとコメントを表示するか
define('PHG_SITE_NAME', ['マイギャラリー', 'My Gallery']); // タイトル（日本語, 英語）
define('PHG_AUTHOR', ['富士見永人', 'Enin Fujimi']); // 管理者名（日本語, 英語）
define('PHG_INDEX_FILE_NAME', "index.php"); // 外部サイトに組み込む場合、ここを変更
