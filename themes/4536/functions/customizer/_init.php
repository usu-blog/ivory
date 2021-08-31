<?php

$arr = [
  'customizer',
  'layout',
  'customizer-media',
  'customizer-color',
  'customizer-function',
];

foreach( $arr as $key ) {
  require_once( "$key.php" );
}
//カスタム背景
add_theme_support( 'custom-background', ['default-color' => 'ffffff',] );
