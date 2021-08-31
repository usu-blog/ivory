<!--[if lt IE 7]> <html class="ie6 min-h-100" <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if IE 7]> <html class="i7 min-h-100" <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if IE 8]> <html class="ie min-h-100" <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="h-100" <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#"> <!--<![endif]-->
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1,viewport-fit=cover">
  <meta name="format-detection" content="telephone=no" />
  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
  <?php
  if(is_rel_canonical()) get_template_part('template-parts/canonical');
  apply_filters( 'wp_head_4536', $meta = '' );
  if(!is_amp()) wp_head();
  get_template_part('template-parts/google-analytics');
  if( !empty( $exclude_category_page_ids = get_option( 'noindex_category_archive' ) ) ) {
    $all_category_ids = get_terms( 'category', ['fields' => 'ids'] );
    $exclude_category_page = array_diff( $all_category_ids, $exclude_category_page_ids );
  } else {
    $exclude_category_page = '';
  }
  if( (!is_category( $exclude_category_page ) && !is_post_type_archive() && is_archive()) || is_search() || is_attachment() || is_404() ) echo '<meta name="robots" content="noindex,follow">';
  if(add_html_js_head()) echo add_html_js_head();
  $amphtml = '<link rel="amphtml" href="'.get_the_permalink().'?amp=1">';
  if(amp_exclude()) $amphtml = null;
  if(is_page_template('page-templates/search-page.php')) $amphtml = null;
  $list = [
      'post' => 'single',
      'page' => 'page',
      'music' => 'media',
      'movie' => 'media',
  ];
  foreach($list as $post_type => $d) {
      if(is_singular($post_type) && is_amp_post_type($d)) echo $amphtml;
  }
  ?>
  <!--[if lt IE 9]>
  <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
  <script src="<?php bloginfo('template_directory'); ?>/js/html5shiv.js"></script>
  <![endif]-->
</head>
