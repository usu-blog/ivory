<?php

add_action('the_content', function($content) {

  //ワンポイントフレーム
  $content = str_replace('<i class="fa fa-check-circle-o"></i>', '<i class="far fa-check-circle"></i>', $content);

  //ブログカード

  return $content;

});
