<?php

function archive_template_4536($page_4536) { ?>
  <div id="contents-wrapper" class="w-100 max-w-100 pa-4">
    <main id="main" class="w-100" role="main">
      <section id="archive-section">
          <?php
          if (is_category()||is_tag()||is_tax()) {
              $title = single_term_title("", false);
          }
          if (is_day()) {
              $title = get_the_time('Y年m月d日');
          }
          if (is_month()) {
              $title = get_the_time('Y年m月');
          }
          if (is_year()) {
              $title = get_the_time('Y年');
          }
          if (is_author()) {
              $title = esc_html(get_queried_object()->display_name);
          }
          if (isset($_GET['paged']) && !empty($_GET['paged'])) {
              $title = 'ブログアーカイブ';
          }
          $title = '「'.$title.'」の記事一覧';
          global $s;
          global $wp_query;
          if (is_search()) {
              $title = '「'.esc_html($s).'」の検索結果 '.$wp_query->found_posts.' 件';
          }
          if ($page_4536==='movie') {
              $title = '「'.esc_html(get_option('sub_media_name')).'」一覧';
          }
          if ($page_4536==='music') {
              $title = '「'.esc_html(get_option('main_media_name')).'」一覧';
          }
          if ($page_4536!=='new') {
              echo '<h1 id="h1" data-text-align="center" class="mb-4">' . $title . '</h1>';
          }
          ?>
          <div class="archive-wrap" data-display="flex" data-justify-content="center">
              <?php post_list_template_4536($page_4536); ?>
          </div>
      </section>
      <?php
      pagination($wp_query->max_num_pages);
      // echo breadcrumb('html');
      ?>
    </main>
  </div>
<?php }

function post_list_template_4536($page_4536)
{

    $count = '';
    $rand = rand(4, 9);

    if (have_posts()) : while (have_posts()) : the_post(); $count++;
      post_list_card_4536(); //記事一覧
      if ($count===$rand && $page_4536==='new' && is_active_sidebar('infeed-ad')) { //インフィード広告?>
          <div class="infeed-ad xs12 sm12 md6 pa-2 card-wrap" data-position="relative">
              <?php dynamic_sidebar('infeed-ad'); ?>
          </div>
      <?php }
    endwhile; else:
      echo '<p>記事がありませんでした。</p>';
    endif;
    wp_reset_postdata();
}

function post_list_card_4536( $title_tag = 'h2' )
{ ?>
  <article class="xs12 sm12 md6 pa-2 card-wrap" data-position="relative">
    <div data-display="flex" data-position="relative" data-flex-direction="column" class="card h-100">
      <?php echo thumbnail_4536($thumbnail_size)['thumbnail']; ?>
      <div class="card-content flex pl-3 pr-3 pt-4 pb-4">
        <?php if (is_home()) {
    $cat = get_the_category();
    $cat_name = $cat[0]->name;
    $cat_slug = $cat[0]->slug;
    $cat_link = esc_url(get_category_link($cat[0]->cat_ID)); ?>
          <div class="z-index-1 meta mb-3" data-display="flex" data-justify-content="center" data-align-items="center">
            <a class="post-color <?php echo $cat_slug; ?>" title="<?php echo $cat_name; ?>" href="<?php echo $cat_link; ?>"><?php echo $cat_name; ?></a>
          </div>
        <?php }
        echo '<' . $title_tag . ' class="card-title title">'; ?>
          <a class="post-color link-mask" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        <?php echo '</' . $title_tag . ' >'; ?>
      </div>
      <div class="flex"></div>
      <div data-display="flex" data-align-items="center" class="card-meta pa-3">
        <?php
        $days = 1;
        $today = date_i18n('U');
        $entry = get_the_time('U');
        $elapsed = date('U', ($today - $entry)) / 86400;
        if( $days > $elapsed ) { ?>
          <span class="new-post pa-2" data-color="white">NEW</span>
        <?php } else { ?>
          <span class="meta"><?php the_time(get_option('date_format')) ?></span>
        <?php } ?>
        <div class="flex"></div>
        <a data-button="submit" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">もっと見る</a>
      </div>
    </div>
  </article>
<?php }
