<?php

namespace php_hp_gallery;

ini_set('display_errors', 1); // エラーメッセージを常時表示する

define('PHG_THUMBNAIL_SIZE', 400); // 自動生成されるサムネのサイズ（実際に表示されるのは CSS の div.thumb.box のサイズ）
define('PHG_THUMBNAILS_PER_CATEGORY', 4); // 全カテゴリ表示モードの時に1カテゴリあたりいくつまでサムネイルを表示するか
define('PHG_THUMBNAILS_PER_PAGE', 4); // カテゴリ表示モードの時に1ページあたりいくつまでサムネイルを表示するか
define('PHG_MULTI_LANGUAGE', true); // 日本語と英語の二ヶ国語表示にするか
define('PHG_TITLE_AND_COMMENT', true); // 画像のタイトルとコメントを表示するか
define('PHG_SITE_NAME', ['マイギャラリー', 'My Gallery']); // タイトル（日本語, 英語）
define('PHG_AUTHOR', ['富士見永人', 'Enin Fujimi']); // 管理者名（日本語, 英語）

define('PHG_PATH', "/home/enin-world/www/files/app/php/php_hp_gallery_2/"); // プロジェクトフォルダのパス（Pフォルダ名含む）
define('PHG_HTTP_PATH', 'http://localhost/myapps/fujimipolis/files/app/php/php_hp_gallery_2/');
define('PHG_INDEX', "index.php"); // 外部サイトに組み込む場合、ここを変更
define('PHG_IMAGES_DIR', PHG_PATH . 'img'); // 画像ファイルのディレクトリ（__DIR__ は現在のディレクトリ取得）
define('PHG_THUMBNAIL_DIR', PHG_PATH . 'thumb'); // サムネイルディレクトリ
define('PHG_IMAGES_HTTP_PATH', PHG_HTTP_PATH . 'img'); // HTTPでアクセスした際にディレクトリが変わるので用意
define('PHG_THUMBNAIL_HTTP_PATH', PHG_HTTP_PATH . 'thumb');
define('PHG_FCM_PATH', "/home/enin-world/www/files/app/php/fp_common_modules/"); // fp_common_modules の場所
define('PHG_HCM_PATH', PHG_FCM_PATH . "html_common_module.php"); // html_common_module.php の場所
define('PHG_PNLG_DIR', PHG_FCM_PATH . 'php_number_link_generator_2/'); // php_number_link_generator_2 のディレクトリ
define('PHG_IU_DIR', PHG_FCM_PATH . 'image_uploader_2/'); // image_uploader_2 のディレクトリ
