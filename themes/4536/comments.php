<aside id="comments" class="pt-5">
  <h2 data-text-align="center" class="mb-3"><?php comments_number( 'コメント', '1件のコメント', '%件のコメント' ); ?></h2>
  <?php if(have_comments()): ?>
    <ol class="comment-list">
        <?php if(is_amp()) {
          $args = [
              'echo' => false
          ];
          $comments = wp_list_comments($args);
          echo convert_content_to_amp($comments);
      } else {
          wp_list_comments();
      } ?>
    </ol>
  <?php endif;
    $args = [
        'title_reply' => 'コメントを書く',
        'lavel_submit' => ('Submit Comment'),
        'id_submit' => 'submit',
    ];
    if(is_amp()) { ?>
        <div id="respond" class="comment-respond">
          <a class="comments-from-amp pa-3 mt-4 mb-4" href="<?php the_permalink();?>#respond" data-text-align="center" data-display="block" data-bg-color="black" data-color="white">コメントを書く</a>
        </div>
    <?php } else {
        comment_form($args);
    }
  ?>
</aside>
