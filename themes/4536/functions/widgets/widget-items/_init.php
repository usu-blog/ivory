<?php
require_once('new-article.php'); //新着記事
require_once('pickup-article.php'); //ピックアップ
require_once('empty.php'); //空のウィジェット
require_once('toc.php'); //目次
require_once('cta.php'); //CTA
require_once('double-rectangle.php'); //ダブルレクタングル
require_once('related-article.php'); //関連記事

function widget_list_4536( $thumbnail = null ) {
  if( is_null($thumbnail) ) $thumbnail = thumbnail_4536('widget')['thumbnail'];
  ?>
  <li data-position="relative" class="mb-4">
    <?php echo $thumbnail; ?>
    <a class="post-color link-mask widget-post-title" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
  </li>
<?php }
