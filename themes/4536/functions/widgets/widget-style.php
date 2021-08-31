<?php

class Widget_Style_Setting_4536 {

  public $widget_color_list = [
    // 'widget_background_color' => '背景色',
    'widget_font_color' => '文字の色',
  ];

  public $is_widget_color = [
    // 'is_widget_background_color' => '',
    'is_widget_font_color' => '',
  ];

  // public $background_image = [
  //   'background_image' => '',
  //   'background_attachment' => '',
  // ];

  public $align = [
    null => 'デフォルト',
    'alignwide' => '幅広',
    'alignfull' => '全幅（全体幅を無視して広げる）',
    'min-w-100' => '全幅（全体幅を考慮して広げる）',
  ];

  function __construct() {
		add_filter( 'in_widget_form_4536', [ $this, 'form' ], 10, 4 );
    add_filter( 'widget_update_callback', [ $this, 'save' ], 20, 4 );
    add_filter( 'dynamic_sidebar_params', [ $this, 'style' ] );
    add_filter( 'inline_style_4536', [ $this, 'css' ] );
	}

  function form( $form, $widget, $return, $instance ) {
    foreach( $this->widget_color_list as $name => $description ) { //ウィジェットの色設定 ?>
      <p>
        <input type="checkbox" class="widefat" id="<?php echo $widget->get_field_id('is_'.$name); ?>" name="<?php echo $widget->get_field_name('is_'.$name); ?>" <?php checked($instance['is_'.$name], 1);?> value="1" />
        <label for="<?php echo $widget->get_field_id('is_'.$name); ?>"><?php _e($description.'を指定する'); ?></label>
        <input type="color" class="widefat" id="<?php echo $widget->get_field_id($name); ?>" name="<?php echo $widget->get_field_name($name); ?>" value="<?php echo $instance[$name]; ?>" />
      </p>
    <?php } ?>
    <p>
      <label for="<?php echo $widget->get_field_id('align'); ?>"><?php _e('ウィジェットの幅'); ?></label>
      <select class="widefat" id="<?php echo $widget->get_field_id('align'); ?>" name="<?php echo $widget->get_field_name('align'); ?>" type="text">
        <?php foreach( $this->align as $display => $description ) { ?>
          <option value="<?php echo $display; ?>"<?php echo ( $instance['align'] === $display ) ? ' selected' : ''; ?>>
            <?php echo $description; ?>
          </option>
        <?php } ?>
      </select>
    </p>
    <!-- <p>
      <label for="<?php echo $widget->get_field_id( 'background_image' ); ?>"><?php _e( '背景画像' ); ?></label>
      <input class="widefat" id="<?php echo $widget->get_field_id( 'background_image' ); ?>" name="<?php echo $widget->get_field_name( 'background_image' ); ?>" type="text" value="<?php echo esc_url( $instance['background_image'] ); ?>" />
      <button class="upload-image-button button button-primary">選択</button>
      <button class="delete-image-button button">削除</button>
      <img class="widefat" src="<?php echo esc_url( $instance['background_image'] ); ?>" style="margin:1em 0;display:block">
    </p> -->
    <!-- <p><label><input class="widefat" name="<?php echo $widget->get_field_name('background_attachment'); ?>" value="fixed" <?php checked($instance['background_attachment'], 'fixed');?> type="checkbox"><?php _e( '背景画像を固定する' ); ?></label></p> -->
  <?php }

  function save( $instance, $new_instance, $old_instance, $object ) {
    $list = $this->widget_color_list;
    $list += $this->is_widget_color;
    // $list += $this->background_image;
    $list['align'] = '';
    foreach( $list as $type => $name ) {
      $instance[$type] = !empty($new_instance[$type]) ? $new_instance[$type] : '';
    }
    return $instance;
  }

  function css( $css ) {
    global $wp_registered_widgets;
    foreach(wp_get_sidebars_widgets() as $int => $ids) {
      foreach($ids as $int => $id) {
        $class = ".$id";
        $widget_obj = $wp_registered_widgets[$id];
        $num = preg_replace('/.*?-(\d)/', '$1', $id);
        $widget_opt = get_option($widget_obj['callback'][0]->option_name);
        $widget_font_color = $widget_opt[$num]['widget_font_color'];
        $is_widget_font_color = $widget_opt[$num]['is_widget_font_color'];
        $font_color = ($is_widget_font_color && $widget_font_color) ? 'color:'.$widget_font_color.';border-color:'.$widget_font_color : '';
        // $widget_background_color = $widget_opt[$num]['widget_background_color'];
        // $is_widget_background_color = $widget_opt[$num]['is_widget_background_color'];
        // $margin = $widget_opt[$num]['margin'];
        // $padding = $widget_opt[$num]['padding'];
        // $background_color = ($is_widget_background_color && $widget_background_color) ? 'background-color:'.$widget_background_color : '';
        // $src = $widget_opt[$num]['background_image'];
        // if( !empty( $src ) ) {
        //   $background_image = 'background-image:url(' . $src . ')';
        //   $attachment = $widget_opt[$num]['background_attachment'];
        //   if( !empty( $attachment ) ) $background_image .= ';background-attachment:' . $attachment;
        //   $css[] = $class.'{' . $background_image . '}';
        // }
        // if( !empty( $background_color ) ) $css[] = $class.'{'.$background_color.'}';
        // if( $margin !== '' && !is_null( $margin )  ) $css[] = $class.'{margin:'.$margin.'}';
        // if( $padding !== '' && !is_null( $padding ) ) $css[] = $class.'{padding:'.$padding.'}';
        if( !empty( $font_color ) ) {
          $classes = [];
          $classes[] = $class . ' :not(.widget-title)';
          $classes[] = $class.' a';
          // $classes[] = $class.' .widget-title';
          // $classes[] = $class.' .widget-title::before';
          // $classes[] = $class.' .widget-title::after';
          $classes = implode( ',', $classes );
          $css[] = $classes.'{'.$font_color.'}';
        }
      }
    }
    return $css;
  }

  //参考：https://gist.github.com/CEscorcio/5669905
  function style( $params ) {
    global $wp_registered_widgets;
    $widget_id = $params[0]['widget_id'];
    $widget_obj = $wp_registered_widgets[$widget_id];
    $widget_opt = get_option($widget_obj['callback'][0]->option_name);
    $widget_num = $widget_obj['params'][0]['number'];
    $arr = [
      'align',
    ];
    foreach( $arr as $key ) {
      if( empty( $widget_opt[$widget_num][$key] ) ) continue;
      $class .= $widget_opt[$widget_num][$key] . ' ';
    }
    if( !empty( $class ) ) $params[0]['before_widget'] = preg_replace( '/class="/', 'class="' . $class, $params[0]['before_widget'], 1 );
    return $params;
  }

}
new Widget_Style_Setting_4536();
