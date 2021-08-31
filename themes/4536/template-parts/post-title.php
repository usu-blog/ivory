<?php
if (is_page_template('page-templates/simple-page.php')
  || is_page_template('page-templates/search-page.php')
) {
    return;
}

$none_thumbnail = get_post_meta($post->ID, 'none_post_thumbnail', true);
if( $none_thumbnail || !has_post_thumbnail() ) {
  $md_flex = ' md12';
  $margin = ' mt-5';
} else {
  $md_flex = ' md6';
  $margin = '';
}
?>
<div class="container mx-auto pb-4<?php echo $margin; ?>" data-display="flex" data-align-items="center" data-justify-content="center" data-position="relative">
  <div id="post-title" class="xs12 sm12 pr-3 pl-3 mt-5 gradation-object gradation-object-right<?php echo $md_flex; ?>" data-position="relative">
    <h1 id="h1" class="mb-3" data-text-align="center"><?php the_title(); ?></h1>
    <div class="meta" data-display="flex" data-align-items="center" data-justify-content="center">
      <?php
      $font_color = font_color();
      //date
      $ptime = get_the_date();
      $mtime = get_mtime();
      if ($mtime) {
          $posted_datetime = $ptime;
          $modified_datetime = '<time datetime="'.get_the_modified_time('c').'">'.$mtime.'</time>';
      } else {
          $posted_datetime = '<time datetime="'.get_the_time('c').'">'.$ptime.'</time>';
          $modified_datetime = $mtime;
      }
      $ptime = '<span class="posted-date">'.$posted_datetime.'</span>';
      $date = ($mtime) ? '<span class="modified-date">'.$modified_datetime.'</span>' : $ptime ;
      $post_date = '<span class="post-date post-data pa-2" data-display="flex" data-align-items="center">' . icon_4536('clock', $font_color, 16) . $date . '</span>';
      echo $post_date;
      //category
      if (has_category()) {
          $cat = get_the_category();
          $cat_name = $cat[0]->name;
          $cat_link = esc_url(get_category_link($cat[0]->cat_ID)); ?>
        <span class="pa-2" data-display="flex" data-align-items="center">
          <?php echo icon_4536('folder', $font_color, 16); ?>
          <a class="flex-1 post-color" title="<?php echo $cat_name; ?>" href="<?php echo $cat_link; ?>"><?php echo $cat_name; ?></a>
        </span>
      <?php
      } ?>
      <!-- author -->
      <span class="pa-2" data-display="flex" data-align-items="center">
        <span>By</span>
        <?php
        $post_author = $post->post_author;
        $author = get_the_author_meta('display_name', $post_author);
        $avatar = get_avatar($post_author, 16);
        if (is_amp()) {
            $avatar = str_replace('<img', '<amp-img', $avatar);
        }
        echo $avatar;
        ?>
        <a class="flex-1 post-color" title="<?php echo $author . 'の記事一覧'; ?>" href="<?php echo get_author_posts_url($post_author); ?>"><?php echo $author; ?></a>
      </span>
    </div>
    <div id="share-button-post-top">
      <?php sns_button_4536(); ?>
    </div>
  </div>
  <?php if(!$none_thumbnail) the_post_thumbnail_4536(); ?>
</div>
