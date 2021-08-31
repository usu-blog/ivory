<?php

if(!is_admin()) return;

//global $wp_version;
//if(version_compare( $wp_version, '5.0', '>=' )) return;
//if(strpos($wp_version, 'beta') !== false) return;

//ビジュアルエディターの設定
require_once('editor-setting.php');
//ビジュアルエディターのオリジナルタグ
require_once('editor-original-tag.php');
//エディタメニュー
require_once('mce-buttons.php');
