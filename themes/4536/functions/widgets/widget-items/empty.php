<?php

class EmptyWidgetItem extends WP_Widget {
    
    function __construct() {
		parent::__construct(
			'empty_item',
			__( '(4536)空のアイテム', '4536' ),
			[ 'description' => __( '入力されたものをそのまま出力します。', '4536' ), ]
		);
	}
    
    function widget($args, $instance) {
        extract( $args );
        $item_new = apply_filters( 'empty_widget_item', $instance['empty_item'] );
        echo $item_new;
    }
    
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['empty_item'] = $new_instance['empty_item'];
        return $instance;
    }
    
    function form($instance) { ?>
        <p>
            <textarea class="widefat" rows="10" id="<?php echo $this->get_field_id('empty_item'); ?>" name="<?php echo $this->get_field_name('empty_item'); ?>"><?php echo esc_textarea( $instance['empty_item'] ); ?></textarea>
        </p>
        <?php
    }
}
add_action( 'widgets_init', function() { register_widget( 'EmptyWidgetItem' ); });
