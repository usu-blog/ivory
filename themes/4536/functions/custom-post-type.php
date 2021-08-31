<?php
add_action('init', function () {
    $main_post_type = esc_html(get_option('main_media_slug'));
    $admin_main_media = esc_html(get_option('admin_main_media'));
    $sub_post_type = esc_html(get_option('sub_media_slug'));
    $admin_sub_media = esc_html(get_option('admin_sub_media'));
    // ミュージック
    if (!empty($admin_main_media)) {
        register_post_type('music', [
      'labels' => [
        'name' => __($admin_main_media),
        'singular_name' => __($admin_main_media),
        'all_items' => __($admin_main_media.' 一覧')
      ],
      'public' => true,
      'show_in_rest' => true,
      'has_archive' => true,
      'rewrite' => [
        'slug' => $main_post_type
      ],
      'menu_position' => 5,
      'supports' => [
        'title',
        'editor',
        'thumbnail',
        'revisions',
        'comments',
        'author',
      ],
    ]);
    }
    // ムービー
    if ($admin_sub_media) {
        register_post_type('movie', [
      'labels' => [
        'name' => __($admin_sub_media),
        'singular_name' => __($admin_sub_media),
        'all_items' => __($admin_sub_media.' 一覧')
      ],
      'public' => true,
      'show_in_rest' => true,
      'has_archive' => true,
      'rewrite' => [
        'slug' => $sub_post_type
      ],
      'menu_position' => 5,
      'supports' => [
        'title',
        'editor',
        'thumbnail',
        'revisions',
        'comments',
        'author',
      ],
    ]);
    }
});

function media_section_4536($media, $args = [])
{
  if(is_page_template('page-templates/simple-page.php')) return;
    global $post;
    $args = [
    'post_type' => $media,
    'posts_per_page' => -1,
    'post__not_in' => [$post->ID],
  ];
    switch ($media) {
    case 'music':
      $is_media = get_option('admin_main_media');
      $section_title = get_option('main_media_name');
      break;
    case 'movie':
      $is_media = get_option('admin_sub_media');
      $section_title = get_option('sub_media_name');
      break;
    case 'pickup':
      $args['post_type'] = 'post';
      $is_media = $section_title = $args['tag'] = 'Pickup';
      break;
  }
  if (empty($is_media)) {
      return;
  }
  $customPosts = get_posts($args);
  if (empty($customPosts)) {
      return;
  }

  if( $media==='pickup' ) { ?>
    <div id="pickup" class="pt-5">
      <p data-text-align="center" class="headline mb-3">Pickup</p>
      <div data-display="flex" data-justify-content="center">
        <?php
        foreach ($customPosts as $post) : setup_postdata($post);
        post_list_card_4536();
        endforeach;
        wp_reset_postdata();
        ?>
      </div>
    </div>
  <?php } else { ?>
    <div id="<?php echo $media ?>" class="media-section wave-shape-outline gradation mt-5 mb-5" data-position="relative">
      <?php wave_shape('media_top'); ?>
      <div data-position="relative" class="pa-4">
        <p data-text-align="center" class="headline mt-5 mb-3"><?php echo esc_html($section_title); ?></p>
        <div data-text-align="center" data-overflow-y="hidden" class="scroll-container">
          <div data-display="table" class="scroll-content mx-auto">
            <?php foreach ($customPosts as $post) : setup_postdata($post); ?>
              <div class="<?php echo $media; ?>-content mr-4" data-display="inline-block" data-text-align="left" data-position="relative">
                <?php echo thumbnail_4536($media)['thumbnail']; ?>
                <span data-display="block" class="mt-2"></span>
                <a class="link-mask mt-2" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </div>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
          </div>
        </div>
        <div class="rightbutton" data-display="none">
          <div data-button="floating" data-bg-color="white" data-position="absolute" class="mr-1 t-50 r-0">
            <?php echo icon_4536('arrow_right', '', 36); ?>
          </div>
        </div>
        <div class="leftbutton" data-display="none">
          <div data-button="floating" data-bg-color="white" data-position="absolute" class="ml-1 t-50 l-0">
            <?php echo icon_4536('arrow_left', '', 36); ?>
          </div>
        </div>
      </div>
      <?php wave_shape('media_bottom'); ?>
    </div>
  <?php }

}
