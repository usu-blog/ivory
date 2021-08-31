<section class="author-card mt-5" data-position="relative">
  <div class="body-bg-color author-avatar t-0" data-position="absolute">
    <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
  </div>
  <div class="author-content gradation l-h-140">
    <h3 data-text-align="center" class="pt-5"><?php the_author(); ?></h3>
    <div class="user-description pa-4">
      <p><?php the_author_meta('user_description'); ?></p>
    </div>
    <hr class="section-break" />
    <div id="follow-me" data-display="flex" data-justify-content="flex-end" class="pt-3 pb-3 pr-4 pl-4">
      <?php

      $list = [
        'twitter' => 'twitter.com',
        'facebook' => 'www.facebook.com',
        'spotify' => 'open.spotify.com/user',
        'soundcloud' => 'soundcloud.com',
        'instagram' => 'www.instagram.com',
      ];

      foreach ($list as $key => $link) {
          if (empty($meta = get_the_author_meta($key))) {
              continue;
          }
          $a_tag = '<a href="//'.$link.'/'.$meta.'" target="_blank" title="'.ucfirst($key).'をフォロー" rel="nofollow" class="mr-2 ml-2"><i class="fab fa-'.$key.' fa-lg" aria-hidden="true"></i></a>';
          echo '<span class="follow-button">'.$a_tag.'</span>';
      }
      ?>
    </div>
  </div>
</section>
