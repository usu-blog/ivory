<?php

if(empty(custom_blogcard())) return;

  // if(preg_match('/<blockquote class="wp-embedded-content".*?<\/blockquote>/i', $output, $match) !== 1) return $output;
  // $output = str_ireplace($match[0], '', $output);
  // $cite = str_ireplace('<blockquote', '<cite data-embed-content-4536="true"', $match[0]);
  // $cite = str_ireplace('</blockquote>', '</cite>', $cite);
  // $output = $output.$cite;
  // return $output;

/**
 * 正規表現参考：https://github.com/yhira/cocoon/blob/master/lib/blogcard-out.php
 */
class ConvertEmbedContentFrom_url_4536 {

  function __construct() {
    // add_filter('embed_html', [$this, 'create_embed_content_before']); //前
    // add_filter( 'embed_oembed_html', [$this, 'create_embed_content_before'] ); //後
    add_filter('oembed_dataparse', [$this, 'create_embed_content_before'] ); //内部用
    add_filter('the_content', [$this, 'create_embed_content_after']); //外部用
  }

  function create_embed_content_from_url( $url ) {

    $transient = 'blogcard_cache_4536_' . md5( $url );

    $cache = get_transient( $transient );

    if( $cache !== false ) return $cache;

    $data = $this->get_data_from_internal_link( $url );

    if( $data !== false ) {
      $thumbnail = $data['thumbnail'];
      $sitename = $data['sitename'];
      $icon = $data['icon'];
      $comment = $data['comment'];
    } else {
      $data = $this->get_data_from_external_link($url);
      if( $data === false ) return '<p><del>'.$url.'</del></p>';
      $thumbnail = ( !empty($data['src']) ) ? '<img width="150" height="150" src="'.$data['src'].'" class="external-thumbnail" />' : '';
      $sitename = $data['host'];
    }

    $title = wp_strip_all_tags( $data['title'] );

    $excerpt = ( !empty($data['excerpt']) ) ? $data['excerpt'] : $title;
    $excerpt = wp_strip_all_tags( $excerpt );

    $more_text = ( isset($data['more_text']) === true ) ? '<span class="blogcard-more-wrap"><span class="blogcard-more link-color">'.$data['more_text'].'</span></span>' : '';

    $icon = ( isset($icon)===true && !empty($icon) ) ? $icon : '<img width="16" height="16" src="https://www.google.com/s2/favicons?domain='.$url.'" />';

    $comment = ( isset($comment) && !empty($comment) ) ? '<span data-display="flex" class="wp-embed-comments">' . icon_4536('comment', '', 16) . '<span>'.$comment.'</span></span>' : '';

    if ( is_my_website( $url ) === true ) {
      $blockquote_begin = $blockquote_end = '';
      $external_link = '';
    } else {
      $blockquote_begin = '<blockquote class="external-website-embed-content" cite="'.$url.'"><p>';
      $blockquote_end = '</p></blockquote>';
      $external_link = ' target="_blank" rel="noreferrer noopener"';
    }

    $link_text = '<a title="' . $title . '" href="' . $url . '" class="post-color title wp-embed-heading link-mask"' . $external_link . '>' . $title . '</a>';
    $excerpt = ( !empty($excerpt) ) ? '<span class="wp-embed-excerpt">'.$excerpt.'</span>' : '';

    if ( empty($thumbnail) ) return '<a data-embed-content="false" href="'.$url.'"'.$external_link.'>'.$data['title'].'</a>';

    $image_size = (thumbnail_size()=='thumbnail') ? ' thumbnail' : ' thumbnail-wide' ;

    $output = <<< EOM
    {$blockquote_begin}
    <span data-display="block" class="card-wrap pa-2">
      <span data-embed-content="true" data-display="flex" data-position="relative" data-flex-direction="column" class="wp-embed card h-100">
        <span data-position="relative" class="wp-embed-featured-image post-thumbnail w-100">
          {$thumbnail}
        </span>
        <span class="card-content flex pl-3 pr-3 pt-4 pb-4">
          {$link_text}
        </span>
        <span data-display="flex" data-align-items="center" class="card-meta pa-3 l-h-100 wp-embed-footer">
          <span class="site_icon">{$icon}</span>
          <span class="wp-embed-site-title ml-2 mr-2">{$sitename}</span>
          <span class="flex"></span>
          <span><a data-button="submit" title="{$title}" href="{$url}">もっと見る</a></span>
        </span>
      </span>
    </span>
    {$blockquote_end}
EOM;

    set_transient(
      $transient,
      $output,
      WEEK_IN_SECONDS //1週間
    );

    return $output;

  }

  function create_embed_content_before($output) {
    if ( preg_match('/<blockquote class="wp-embedded-content".*?><a href="(.+?)"/i', $output, $match) !== 1 ) return $output;
    $url = esc_url($match[1]);
    if ( is_my_website( $url ) === false ) return $url;
    $html = $this->create_embed_content_from_url($url);
    return $html;
  }

  function create_embed_content_after($content) {

    $res = preg_match_all('/^(<p>)?(<a[^>]+?>)?https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+(<\/a>)?(?!.*<br *\/?>).*?(<\/p>)?/im', $content, $matches);

    if ( empty($res) ) return $content;
    foreach ($matches[0] as $match) {
      $url = esc_url( strip_tags($match) );
      $content = preg_replace('{^'.preg_quote($match, '{}').'}im', $this->create_embed_content_from_url($url), $content, 1);
    }

    return $content;
  }

  function get_data_from_internal_link($url) {

    $id = url_to_postid($url);

    $sitename = ( !empty( site_title() ) ) ? site_title() : get_bloginfo('name');

    $icon = wp_get_attachment_image( get_option('site_icon'), [16,16] );

    // if(thumbnail_size()==='thumbnail') {
    //     $thumb500 = [500,500];
    // } else {
    //     $thumb500 = [500,375];
    // }
    if(has_post_thumbnail($id)) {
      $thumbnail = get_the_post_thumbnail($id, $thumb, ['class' => 'blogcard-thumb-image'] );
    } else {
      $thumbnail = get_some_image_4536($content);
    }

    if ( $id !== 0 ) {
      $data = get_post( $id );
      $title = get_the_title( $id );
      $content = do_shortcode( $data->post_content );
      $comment = $data->comment_count;
      $more_text = '続きを見る';
    } else {
      if ( $url === site_url() ) {
        $title = $sitename;
        $content = (custom_home_description()) ? custom_home_description() : get_bloginfo('description');
      } else {
        $path = str_replace( site_url().'/', '', $url );
        // $parse_url = parse_url( $url );
        $path = explode( '/', $path );
        if ( !is_array($path) ) return false;
        // $reverse_path = array_reverse($path);
        $type = $path[0];
        $slug = end( $path );
        if ( $type === 'category' ) {
          $cat = get_term_by( 'slug', $slug, 'category' );
          $title = $cat->name.'の記事一覧';
          $excerpt = ( !empty($cat->description) ) ? $cat->description : '';
        } elseif ( $type === 'tag' ) {
          $tag = get_term_by( 'slug', $slug, 'post_tag' );
          $title = $tag->name.'の記事一覧';
          $excerpt = ( !empty($tag->description) ) ? $tag->description : '';
        } elseif ( $type === 'author' ) {
          $excerpt = get_user_by( 'slug', $slug )->display_name.'の記事一覧';
        } else {
          return false;
        }
      }
    }

    // if ( $cat = get_category_by_path($url, false) ) {
    //   //https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/get_category_by_path
    // }

    return compact(
      'title',
      'thumbnail',
      'sitename',
      'icon',
      'comment',
      'more_text'
    );
  }

  function get_data_from_external_link( $url ) {

    $transient = 'ogp_cache_4536_' . md5( $url );

    $data = $cache = get_transient( $transient );

    if( $cache === false ) {
      $data = [];
      $data = OpenGraph::fetch($url);
      set_transient(
        $transient,
        $data,
        WEEK_IN_SECONDS //1週間
      );
    }

    if( !is_object($data) ) return false;

    if( !empty( $data ) ) $data = [
      'title' => $data->title,
      'src' => $data->image,
      'host' => parse_url(esc_url($url))['host'],
    ];
    return $data;
  }

}
new ConvertEmbedContentFrom_url_4536();

// add_filter( 'pre_oembed_result', function($html, $url, $args) {
//   //
// }, 10, 3);

add_filter('template_include', function( $template ) {
  //include_test
  // $template = __DIR__.'/template.php';
  return $template;
});

add_filter( 'embed_head', function() {
  wp_enqueue_style( 'wp-embed-4536', get_parent_theme_file_uri('functions/embed/css/oembed.min.css') );
});
// remove_action( 'embed_head', 'print_embed_styles' );

// add_filter( 'the_excerpt_embed', function() {
//   $excerpt = custom_excerpt_4536(get_the_content(), 80);
//   return $excerpt;
// });
