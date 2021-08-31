<?php

///////////////////////////////////
// h2タグの前にウィジェットを出力
///////////////////////////////////
add_filter('the_content', function($the_content) {
  if(is_amp()) {
    if(!empty(amp_adsense_code('before_h2')) && is_amp_before_1st_h2()) {
      $ad = amp_adsense_code('before_h2');
    } elseif(is_active_sidebar('amp-first-h2-ad')) {
      ob_start();
      dynamic_sidebar('amp-first-h2-ad');
      $ad = ob_get_clean();
    }
  } else {
    if(is_active_sidebar('sp-first-h2-ad')) {
      ob_start();
      dynamic_sidebar('sp-first-h2-ad');
      $ad = ob_get_clean();
    }
  }
  if( is_single() && !empty($ad) ) {
    preg_match( '/<h2.*?>/i', $the_content, $h2 );
    $h2 = $h2[0];
    if($h2) $the_content = preg_replace('/<h2.*?>/i', $ad.$h2, $the_content, 1);
  }
  return $the_content;
});

///////////////////////////////////
// ウィジェットのタイトル消す
///////////////////////////////////
add_filter( 'widget_title', function( $widget_title ) {
  return ( substr( $widget_title, 0, 1 ) === '!' ) ? null : $widget_title ;
});

///////////////////////////////////
// ウィジェットのフォーム追加
///////////////////////////////////
add_action( 'in_widget_form', function( $widget, $return, $instance ) { ?>
  <div class="widget-display-setting-area-4536" style="display:none;">
    <?php apply_filters( 'in_widget_form_4536', $form, $widget, $return, $instance ); ?>
  </div>
<?php }, 10, 3 );

///////////////////////////////////
// ウィジェットの記事表示数
///////////////////////////////////
function widget_post_count_4536() {
  global $wp_registered_widgets;
  foreach(wp_get_sidebars_widgets() as $int => $ids) {
    foreach($ids as $int => $id) {
      $widget_obj = $wp_registered_widgets[$id];
      $num = preg_replace('/.*?-(\d)/', '$1', $id);
      $widget_opt = get_option($widget_obj['callback'][0]->option_name);
      $new_post_count[] = $widget_opt[$num]['entry_count'];
      $pickup_post_count[] = $widget_opt[$num]['pickup_count'];
    }
  }
  $new_post_count = (max($new_post_count)) ? max($new_post_count) : 5;
  $pickup_post_count = (max($pickup_post_count)) ? max($pickup_post_count) : 5;
  return [
    'new_post_count' => $new_post_count,
    'pickup_post_count' => $pickup_post_count,
  ];
}

///////////////////////////////////
// リスト
///////////////////////////////////
add_filter( 'wp_list_categories', 'posted_count_in_textlink_4536'); //カテゴリ
add_filter( 'get_archives_link', 'posted_count_in_textlink_4536'); //アーカイブ
function posted_count_in_textlink_4536($output) {
    $output = str_replace( '<li', '<li data-display="flex"', $output );
    $output = str_replace( '<a', '<a data-text="ellipsis" class="flex-1 archive-list"', $output );
    return $output;
}

// add_filter( 'widget_display_callback', function( $instance, $widget, $args ) {
//     if( $widget->id_base === 'categories' ) $instance = false;
//     return $instance;
// }, 10, 3);

///////////////////////////////////
// ウィジェットページにCSS追加
///////////////////////////////////
add_action( 'admin_head-widgets.php', function() { ?>
  <!-- スタイル -->
  <style>
    .tab-item {
        width: 25%;
        border-bottom: 3px solid #00acff;
        border-right: 1px solid #00acff;
        background-color: #d9d9d9;
        color: #565656;
        font-size: 10px;
        text-align: center;
        display: block;
        float: left;
        font-weight: bold;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        padding: .5em;
    }
    .tab-item:last-of-type {
        border-right: none;
    }
    .tab-item:hover {
        opacity: 0.7;
    }
    input[name="tab_item"] {
        display: none;
    }
    .tab_content {
        display: none;
        padding: 0 1em;
        height: 150px;
        overflow-y: scroll;
        clear: both;
        border-left: 1px solid #ccc;
        border-right: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
    }
    .tabs input:checked + .tab-item {
        background-color: #00acff;
        color: #fff;
    }
    .tab_content .category-list .children {
        margin: 6px 0 0 20px;
    }
  </style>
  <!-- 「設定」ボタン追加 -->
  <script>
    $(function() {
      $('.widget-control-actions').each(function() {
        var button = $( '<input>' );
        button.addClass( 'widget-display-button-4536 button' )
          .attr({
            'type' : 'button',
            'name' : 'widget_display_button_4536',
            'value' : '設定'
          })
          .css({
            'margin-right':'5px'
          });
        button.prependTo( $(this).find('.alignright') );
        $(this).find('.spinner').css('float','left');
      });
    });
    $(function() {
      $(document).on( 'click', '.widget-display-button-4536', function() {
        var setting_area = $(this).closest('.widget-inside').find('.widget-display-setting-area-4536');
        if( setting_area.css('display') === 'none' ) {
          setting_area.fadeIn();
        } else {
          setting_area.hide();
        }
      });
    });
  </script>
<?php }, 20 );
