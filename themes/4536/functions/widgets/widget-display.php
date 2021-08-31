<?php

class Widget_Display_4536 {

  public $list_default = [
    'widget_display_post_id' => '投稿記事',
    'widget_display_page_id' => '固定ページ',
    'widget_display_cat_id' => 'カテゴリー',
    'widget_display_all' => '全体',
  ];
  public $page_type_list = [
    'widget_display_home' => 'トップページ',
    'widget_display_pc' => 'PC（タブレット）ページ',
    'widget_display_mobile' => 'モバイル（スマホ）ページ',
    'widget_display_single' => '投稿記事',
    'widget_display_page' => '固定ページ',
    'widget_display_category' => 'カテゴリーページ',
    'widget_display_tag' => 'タグページ',
    'widget_display_search' => '検索結果ページ',
    'widget_display_404' => '404ページ',
    'widget_display_ios' => 'iOSデバイス',
    'widget_display_android' => 'Androidデバイス',
    'widget_display_mac' => 'Mac',
    'widget_display_windows' => 'Windows',
    'widget_display_windows_phone' => 'Windows Phone',
  ];
  public $widget_display = [
    null => '条件を適用しない（本来の動作）',
    'show_widget' => '指定ページだけに表示する',
    'hide_widget' => '指定ページ以外で表示する',
  ];

  function __construct() {
		add_filter( 'in_widget_form_4536', [ $this, 'form' ], 10, 4 );
    add_filter( 'widget_update_callback', [ $this, 'save_settings' ], 20, 4 );
    add_filter( 'admin_head-widgets.php', [ $this, 'all_check' ] );
    add_filter( 'widget_display_callback', [ $this, 'widget_display' ], 999, 3 );
	}

  function form( $form, $widget, $return, $instance ) { ?>
    <div class="tabs">
      <span style="display:block">表示条件</span>
      <?php
      $list = $this->list_default;
      foreach( $list as $type => $name ) {
        $check = ($type==='widget_display_post_id') ? 'checked' : '';
        ?>
        <input id="widget_display_setting-<?php echo $widget->get_field_id($type);?>" type="radio" name="tab_item" <?php echo $check; ?>>
        <label class="tab-item" for="widget_display_setting-<?php echo $widget->get_field_id($type);?>"><?php echo $name; ?></label>
      <?php }
      $list_tab_content = [
        'widget_display_post_id' => '投稿記事',
        'widget_display_page_id' => '固定ページ',
      ];
      foreach( $list_tab_content as $type => $name ) { ?>
      <div class="tab_content" id="<?php echo $widget->get_field_id($type);?>-content">
        <p>
          <label for="<?php echo $widget->get_field_id($type); ?>"><?php _e($name.'のIDもしくはスラッグ'); ?></label>
          <input type="text" class="widefat" id="<?php echo $widget->get_field_id($type); ?>" name="<?php echo $widget->get_field_name($type); ?>" value="<?php echo esc_attr($instance[$type]); ?>" placeholder="例：12,864,contact,profile" />
        </p>
      </div>
      <?php } ?>
      <div class="tab_content" id="<?php echo $widget->get_field_id('widget_display_cat_id');?>-content">
        <div class="category-all-check">
          <input type="checkbox" class="widefat" id="<?php echo $widget->get_field_id('widget_display_category_all_check'); ?>" name="<?php echo $widget->get_field_name('widget_display_category_all_check'); ?>" <?php checked($instance['widget_display_category_all_check'], 1);?> value="1" />
          <label class="button" for="<?php echo $widget->get_field_id('widget_display_category_all_check'); ?>">すべて選択</label>
        </div>
        <?php
        $defaults = array( 'widget_display_cat_id' => array() );
        $instance = wp_parse_args( (array) $instance, $defaults );
        $walker = new Walker_Category_Checklist_Widget (
          $widget->get_field_name( 'widget_display_cat_id' ),
          $widget->get_field_id( 'widget_display_cat_id' )
        );
        echo '<ul>';
        wp_category_checklist( 0, 0, $instance['widget_display_cat_id'], FALSE, $walker, FALSE );
        echo '</ul>';
        ?>
      </div>
      <div class="tab_content" id="<?php echo $widget->get_field_id('widget_display_all');?>-content">
        <div class="post-type-all-check">
          <input type="checkbox" class="widefat" id="<?php echo $widget->get_field_id('widget_display_post_type_all_check'); ?>" name="<?php echo $widget->get_field_name('widget_display_post_type_all_check'); ?>" <?php checked($instance['widget_display_post_type_all_check'], 1);?> value="1" />
          <label class="button" for="<?php echo $widget->get_field_id('widget_display_post_type_all_check'); ?>">すべて選択</label>
        </div>
        <ul>
        <?php
        $page_type_list = $this->page_type_list;
        foreach($page_type_list as $type => $name) { ?>
          <li>
            <input type="checkbox" class="widefat" id="<?php echo $widget->get_field_id($type); ?>" name="<?php echo $widget->get_field_name($type); ?>" <?php checked($instance[$type], 1);?> value="1" />
            <label for="<?php echo $widget->get_field_id($type); ?>"><?php echo $name; ?></label>
          </li>
        <?php } ?>
        </ul>
      </div>
    </div>
    <p>
      <label for="<?php echo $widget->get_field_id('widget_display'); ?>"><?php _e('表示設定'); ?></label>
      <select class='widefat' id="<?php echo $widget->get_field_id('widget_display'); ?>" name="<?php echo $widget->get_field_name('widget_display'); ?>" type="text">
        <?php
        $widget_display = $this->widget_display;
        foreach($widget_display as $display => $description) { ?>
          <option value='<?php echo $display; ?>'<?php echo ($instance['widget_display']==$display)?'selected':''; ?>>
            <?php echo $description; ?>
          </option>
        <?php } ?>
      </select>
    </p>
    <?php
    // 参考：https://wp-works.net/how-to-get-id-number-of-added-widget-in-javascript-with-php/
    if( $widget->number == '__i__' ) {
      foreach( $widget->get_settings() as $index => $settings ) {
        $widget_number = intval($index);
      }
      $widget->number = intval($widget_number) + 1;
      $widget->id = str_replace( '__i__', $widget->number, $widget->id );
    } ?>
    <style>
      <?php foreach($list as $type => $name) { ?>
        #widget_display_setting-<?php echo $widget->get_field_id($type);?>:checked ~ #<?php echo $widget->get_field_id($type);?>-content {
          display: block;
        }
      <?php } ?>
    </style>
  <?php }

  function save_settings( $instance, $new_instance, $old_instance, $object ) {
    $list = $this->list_default;
    $list += $this->page_type_list;
    $list['widget_display_category_all_check'] = '';
    $list['widget_display_post_type_all_check'] = '';
    $list['widget_display'] = '';
    foreach( $list as $type => $name ) {
      $instance[$type] = !empty($new_instance[$type]) ? $new_instance[$type] : '';
    }
    return $instance;
  }

  function widget_display($instance, $widget, $args) {
    $post_id = $instance['widget_display_post_id'];
    $post_id = explode(',', $post_id);
    $page_id = $instance['widget_display_page_id'];
    $page_id = explode(',', $page_id);
    $cat_id = $instance['widget_display_cat_id'];
    $single = ($post_id) ? is_single($post_id) : '';
    $page = ($page_id) ? is_page($page_id) : '';
    $cat = ($cat_id) ? in_category($cat_id) : '';
    $cat_child = ($cat_id) ? post_is_in_descendant_category_4536($cat_id) : '';
    if($instance['widget_display_home']) {
      $home = (is_front_page()) ? is_front_page() : is_home();
    } else {
      $home = '';
    }
    $pc = ($instance['widget_display_pc']) ? !is_mobile() : '';
    $mobile = ($instance['widget_display_mobile']) ? is_mobile() : '';
    $is_single = ($instance['widget_display_single']) ? is_single() : '';
    $is_page = ($instance['widget_display_page']) ? is_page() : '';
    $is_cat = ($instance['widget_display_category']) ? is_category() : '';
    $is_tag = ($instance['widget_display_tag']) ? is_tag() : '';
    $is_search = ($instance['widget_display_search']) ? is_search() : '';
    $is_404 = ($instance['widget_display_404']) ? is_404() : '';
    $is_ios = ($instance['widget_display_ios']) ? is_ios_4536() : '';
    $is_android = ($instance['widget_display_android']) ? is_android_4536() : '';
    $is_mac = ($instance['widget_display_mac']) ? is_macintosh_4536() : '';
    $is_windows = ($instance['widget_display_windows']) ? is_windows_4536() : '';
    $is_windows_phone = ($instance['widget_display_windows_phone']) ? is_windows_phone_4536() : '';
    if($instance['widget_display']==='show_widget') {
        if(!$single
           && !$page
           && !$cat
           && !$cat_child
           && !$home
           && !$is_single
           && !$is_page
           && !$is_cat
           && !$is_tag
           && !$is_search
           && !$is_404
           ) $instance = false;
        if(!$pc
           && !$mobile
           && !$is_ios
           && !$is_android
           && !$is_mac
           && !$is_windows
           && !$is_windows_phone
          ) $instance = false;
        return $instance;
    }
    if($instance['widget_display']==='hide_widget') {
        if($single
           || $page
           || $cat
           || $cat_child
           || $home
           || $is_single
           || $is_page
           || $is_cat
           || $is_tag
           || $is_search
           || $is_404
           ) $instance = false;
        if($pc
           || $mobile
           || $is_ios
           || $is_android
           || $is_mac
           || $is_windows
           || $is_windows_phone
           ) $instance = false;
        return $instance;
    }
    return $instance;
  }

  function all_check() { ?>
      <script>
          $(function() {
              $(document).on('click', '.category-all-check input,.category-all-check label', function() {
                  var items = $(this).closest('.category-all-check').next().find('input');
                  if($(this).is(':checked')) {
                      $(items).prop('checked', true);
                  } else {
                      $(items).prop('checked', false);
                  }
              });
              $(document).on('click', '.post-type-all-check input,.post-type-all-check label', function() {
                  var items = $(this).closest('.post-type-all-check').next().find('input');
                  if($(this).is(':checked')) {
                      $(items).prop('checked', true);
                  } else {
                      $(items).prop('checked', false);
                  }
              });
          });
      </script>
      <style>
        .category-all-check input,.post-type-all-check input {
          display: none;
        }
        .category-all-check,.post-type-all-check {
          margin-top: 1em;
        }
      </style>
  <?php }

}
new Widget_Display_4536();
