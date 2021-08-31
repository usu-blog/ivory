<?php

function breadcrumb( $output = 'json' ) {

  $page_count_url = '';
  $page_count_name = '';
  if( is_paged() ) {
    $page_count = get_query_var( 'paged' );
    $page_count_url = '/page/' . $page_count;
    $page_count_name = '（ページ' . $page_count . '）';
  }
  $object = get_queried_object();

  $pos = 1;

  //トップ
  $site_name = get_bloginfo('name');
  $site_url = site_url();
  $arr[ $pos ] = [
    'name' => $site_name,
    'url' => $site_url,
  ];

  switch ( true ) {

    //フロントページ
    case is_front_page():
      $arr[ $pos ] = [
        'name' => $site_name,
        'url' => $site_url,
      ];
      break;

    //固定ページのブログ投稿インデックス
    case is_home():
      $arr[ $pos + 1 ] = [
        'name' => '投稿一覧' . $page_count_name,
        'url' => rtrim( get_the_permalink( $object->ID ), '/' ) . $page_count_url,
      ];
      break;

    //2ページ目以降
    case is_home() && is_paged():
      $arr[ $pos + 1 ] = [
        'name' => '投稿一覧' . $page_count_name,
        'url' => rtrim( $site_url, '/' ) . $page_count_url,
      ];
      break;

    //カテゴリー、タグ、タクソノミーのアーカイブ
    case is_category():
    case is_tag():
    case is_tax():
      if( $object->parent !== 0 ) {
        $ancestors_id = array_reverse( get_ancestors( $object->term_id, $object->taxonomy ) );
        foreach ( $ancestors_id as $id ) {
          $pos = $pos + 1;
          $arr[ $pos ] = [
            'name' => get_term( $id, $object->taxonomy )->name,
            'url' => get_term_link( $id, $object->taxonomy ),
          ];
        }
      }
      $arr[ $pos + 1 ] = [
        'name' => get_term( $object->term_id, $object->taxonomy )->name . $page_count_name,
        'url' => rtrim( get_term_link( $object->term_id, $object->taxonomy ), '/' ) . $page_count_url,
      ];
      break;

    //オーサーアーカイブ
    case is_author():
      $arr[ $pos + 1 ] = [
        'name' => $object->display_name . $page_count_name,
        'url' => rtrim( get_author_posts_url($object->ID), '/' ) . $page_count_url,
      ];
      break;

    //日付アーカイブ
    case is_year():
    case is_month():
    case is_day():
      $year = get_the_time( 'Y' );
      $month = get_the_time( 'm' );
      $day = get_the_time( 'd' );
      $time['year'] = [
        'name' => $year . '年',
        'url' =>  get_year_link( $year ),
      ];
      $time['month'] = [
        'name' => $month . '月',
        'url' =>  get_month_link( $year, $month ),
      ];
      $time['day'] = [
        'name' => $day . '日',
        'url' =>  get_day_link( $year, $month, $day ),
      ];
      $page_time_count_name = '';
      $page_time_count_url = '';
      foreach( $time as $key => $value ) {
        if( is_month() && $key==='day' ) break;
        if(
          (is_year() && $key==='year') ||
          (is_month() && $key==='month') ||
          (is_day() && $key==='day')
        ) {
          $page_time_count_name = $page_count_name;
          $page_time_count_url = $page_count_url;
        }
        $pos = $pos + 1;
        $arr[ $pos ] = [
          'name' => $value['name'] . $page_time_count_name,
          'url' => rtrim( $value['url'], '/' ) . $page_time_count_url,
        ];
        if( is_year() ) break;
      }
      break;

      //カスタム投稿アーカイブ
      case is_post_type_archive( $type = get_post_type() ):
        switch( $type ) {
          case 'music':
            $name = esc_html(get_option('main_media_name'));
            break;
          case 'movie':
            $name = esc_html(get_option('sub_media_name'));
            break;
          default:
            $name = $object->label;
            break;
        }
        $arr[ $pos + 1 ] = [
          'name' => $name . $page_count_name,
          'url' => rtrim( get_post_type_archive_link( get_post_type() ), '/' ) . $page_count_url,
        ];
        break;

      //検索結果
      case is_search():
        $arr[ $pos + 1 ] = [
          'name' => '「' . get_search_query() . '」の検索結果',
          'url' => rtrim( $site_url, '/' ) . '/?s=' . get_search_query(),
        ];
        break;

      //404ページ
      case is_404():
      $_404_url = ( is_ssl() ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $arr[ $pos + 1 ] = [
          'name' => '404 Not Found',
          'url' => $_404_url,
        ];
        break;

      //投稿記事
      case is_single() && !is_attachment():
        switch (get_post_type()) {
          case 'post':
            $categories = get_the_category( $object->ID );
            $cat = $categories[0];
            if ( $cat->parent !== 0 ) {
              $ancestors = array_reverse( get_ancestors( $cat->term_id, 'category' ) );
              foreach ( $ancestors as $id ) {
                $pos = $pos + 1;
                $arr[ $pos ] = [
                  'name' => get_cat_name( $id ),
                  'url' => get_category_link( $id ),
                ];
              }
            }
            $arr[ $pos + 1 ] = [
              'name' => get_cat_name( $cat->term_id ),
              'url' => get_category_link( $cat->term_id ),
            ];
            break;
          default:
            $object = get_post_type_object( $type = get_post_type() );
            switch( $type ) {
              case 'music':
                $name = esc_html(get_option('main_media_name'));
                break;
              case 'movie':
                $name = esc_html(get_option('sub_media_name'));
                break;
              default:
                $name = $object->label;
                break;
            }
            $arr[ $pos + 1 ] = [
              'name' => $name,
              'url' => get_post_type_archive_link( $type ),
            ];
            break;
        }
        $arr[ $pos + 2 ] = [
          'name' => get_the_title( $object->ID ),
          'url' => get_the_permalink( $object->ID ),
        ];
        break;

      //添付ページ
      case is_attachment():
        $arr[ $pos + 1 ] = [
          'name' => get_the_title( $object->ID ),
          'url' => get_the_permalink( $object->ID ),
        ];
        break;

      //固定ページ
      case is_page():
        if ( $object->post_parent !== 0 ) {
          $ancestors = array_reverse( get_post_ancestors( $object->ID ) );
          foreach ( $ancestors as $id ) {
            $pos = $pos + 1;
            $arr[ $pos ] = [
              'name' => get_the_title( $id ),
              'url' => get_the_permalink( $id ),
            ];
          }
        }
        $arr[ $pos + 1 ] = [
          'name' => get_the_title( $object->ID ),
          'url' => get_the_permalink( $object->ID ),
        ];
        break;

  }

  $elm = [];

  if( $output === 'json' ) {
    foreach( $arr as $key => $value ) {
      $elm[] = '{
        "@type": "ListItem",
        "position": ' . $key . ',
        "name": "' . $value['name'] . '",
        "item": "' . $value['url'] . '"
      }';
    }
    $elm = implode( ',', $elm );
  } elseif ( $output === 'html' ) {
    $arr_count = count( $arr );
    foreach( $arr as $key => $value ) {
      $name = ( $key === 1 ) ? 'ホーム' : $value['name'];
      if( $key !== $arr_count ) {
        $elm[] = '<a href="'.$value['url'].'">'.$name.'</a>';
        continue;
      }
      $elm[] = '<span class="current-breadcrumb">' . $name . '</span>';
    }
    $elm = implode( '<span class="breadcrumb-delimiter"><i class="fas fa-angle-right"></i></span>', $elm );
    $elm = '<div id="breadcrumb">'.$elm.'</div>';
  }

  return $elm;

  //-------- dev mode --------------------
  // echo '<pre>'.$elm.'</pre>';
  // echo '<pre>';var_dump($arr);echo'</pre>';
  // var_dump( $object );
  // var_dump( $arr );
  //-------- dev mode --------------------

}

add_action( 'wp_head_4536', function( $meta ) { ?>
  <script type="application/ld+json">
  {
    "@context": "http://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [<?php echo breadcrumb(); ?>]
  }
  </script>
<?php });
