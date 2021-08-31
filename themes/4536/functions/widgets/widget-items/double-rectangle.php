<?php

class DoubleRectangleWidgetItem extends WP_Widget {

    function __construct() {
		parent::__construct(
			'ad_widget',
			__( '(4536)バナー広告用', '4536' ),
			[ 'description' => __( 'ダブルレクタングル対応/バナー広告に便利なオプション付き', '4536' ), ]
		);
	}

    function form($instance) {
        $list = [
            'rectangle_left' => 'PC画面では左に表示されます。スマホ画面で非表示にする場合は上のチェックボックスにチェックを入れてください。アドセンス広告はスマホ画面では縦に続けて掲載することはできないのでご注意ください。',
            'rectangle_right' => 'PC画面では右に表示されます。スマホ画面で非表示にする場合は上のチェックボックスにチェックを入れてください。アドセンス広告はスマホ画面では縦に続けて掲載することはできないのでご注意ください。',
        ];
        ?>
        <p style="color:red;font-weight:bold"><small>※アドセンス広告を表示する場合は必ず「レスポンシブ広告」をご使用ください。また、モバイル画面では縦に2つ続けて掲載することはできません。</small></p>
        <p>
            <label for="<?php echo $this->get_field_id('ad_title'); ?>"><?php _e('タイトル'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('ad_title'); ?>" name="<?php echo $this->get_field_name('ad_title'); ?>" type="text" value="<?php echo $instance['ad_title']; ?>">
        </p>
        <?php foreach($list as $name => $label) { ?>
        <p>
            <input class="widefat" id="<?php echo $this->get_field_id('display_none_mobile_'.$name); ?>" name="<?php echo $this->get_field_name('display_none_mobile_'.$name); ?>" value="1" <?php checked($instance['display_none_mobile_'.$name], 1);?> type="checkbox">
            <label for="<?php echo $this->get_field_id('display_none_mobile_'.$name); ?>"><?php _e('スマホ画面で非表示にする'); ?></label>
            <textarea class="widefat" rows="10" id="<?php echo $this->get_field_id($name); ?>" name="<?php echo $this->get_field_name($name); ?>" placeholder="<?php _e($label); ?>"><?php echo esc_textarea($instance[$name]); ?></textarea>
        </p>
        <?php } ?>
        <p>
            <input class="widefat" id="<?php echo $this->get_field_id('is_double_rectangle'); ?>" name="<?php echo $this->get_field_name('is_double_rectangle'); ?>" value="double-rectangle" <?php checked($instance['is_double_rectangle'], 'double-rectangle');?> type="checkbox">
            <label for="<?php echo $this->get_field_id('is_double_rectangle'); ?>"><?php _e( 'PC画面でダブルレクタングルにする' ); ?></label>
        </p>
    <?php }

    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['ad_title'] );
        if(!empty($title)) $title = $args['before_title'].$title.$args['after_title'];
        $rectangle_left = apply_filters( 'rectangle_left', $instance['rectangle_left'] );
        $rectangle_right = apply_filters( 'rectangle_right', $instance['rectangle_right'] );
        $display_none_mobile_rectangle_left = apply_filters( 'display_none_mobile_rectangle_left', $instance['display_none_mobile_rectangle_left'] );
        $display_none_mobile_rectangle_right = apply_filters( 'display_none_mobile_rectangle_right', $instance['display_none_mobile_rectangle_right'] );
        $is_double_rectangle = apply_filters( 'is_double_rectangle', $instance['is_double_rectangle'] );

        if(empty($rectangle_left) && empty($rectangle_right)) return;

        if(!empty($display_none_mobile_rectangle_left) && !empty($display_none_mobile_rectangle_right)) {
            $title = '<div data-display="none-sm">'.$title.'</div>';
        }

        echo $args['before_widget'].$title;

        if(!empty($is_double_rectangle)) {
          $class = ' double-rectangle-wrapper';
          $data = ' data-display="flex" data-justify-content="center"';
        } else {
          $class = '';
          $data = '';
        }

        echo '<div class="ad-wrapper'.$class.'"'. $data .'>';

        $ad = '';

        if(!empty($rectangle_left)) {
            $left_data = (!empty($display_none_mobile_rectangle_left)) ? ' data-display="none-sm"' : '';
            $ad .= '<div class="ad ad-left"' . $left_data . '>'.$rectangle_left.'</div>';
        }

        if(!empty($rectangle_right)) {
            $right_data = (!empty($display_none_mobile_rectangle_right)) ? ' data-display="none-sm"' : '';
            $ad .= '<div class="ad ad-right"' . $right_data . '>'.$rectangle_right.'</div>';
        }

        if(!empty($is_double_rectangle)) {
            preg_match('/<ins class="adsbygoogle/i', $ad, $match);
            if(!empty($match)) {
                $ad = str_replace('class="adsbygoogle', 'class="adsbygoogle double-rectangle', $ad);
                $ad = preg_replace('/data-ad-format=".+?"/i', 'data-ad-format="rectangle"', $ad);
            }
        }

        echo (is_amp()) ? convert_content_to_amp($ad) : $ad;

        echo '</div>';

        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $list = [
            'ad_title',
            'is_double_rectangle',
            'rectangle_left',
            'rectangle_right',
            'display_none_mobile_rectangle_left',
            'display_none_mobile_rectangle_right',
        ];
        foreach($list as $name) {
            $instance[$name] = $new_instance[$name];
        }
        return $instance;
    }

}
add_action( 'widgets_init', function() { register_widget( 'DoubleRectangleWidgetItem' ); });
