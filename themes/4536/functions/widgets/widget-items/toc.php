<?php

class TocWidgetItem extends WP_Widget {
    function __construct() {
		parent::__construct(
			'toc',
			__( '(4536)目次', '4536' ),
			array( 'description' => __( '見出しを元に目次を生成します', '4536' ), )
		);
	}
    function widget($args, $instance) {
        global $post;
        if(get_post_meta($post->ID, 'toc', true)) return;
        extract( $args );
        $title_new = apply_filters( 'widget_title', empty($instance['toc_title']) ? '目次' : $instance['toc_title'] );
        $outline_info = get_outline_info_4536($post->post_content);
        $outline = $outline_info['outline'];
        if(is_toc_4536() && $outline) {
            echo $args['before_widget'];
            if($title_new) echo $args['before_title'].$title_new.$args['after_title'];
            $outline = '<div class="toc-4536 toc-sidebar">'.$outline.'</div>';
            echo $outline;
            echo $args['after_widget'];
        }
    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['toc_title'] = strip_tags($new_instance['toc_title']);
        return $instance;
    }
    function form($instance) {
        $title_new = esc_attr($instance['toc_title']);
        ?>
        <p>
          <label for="<?php echo $this->get_field_id('toc_title'); ?>">
          <?php _e('目次のタイトル'); ?>
          </label>
          <input class="widefat" id="<?php echo $this->get_field_id('toc_title'); ?>" name="<?php echo $this->get_field_name('toc_title'); ?>" type="text" value="<?php echo $title_new; ?>" />
        </p>
        <?php
    }
}
add_action( 'widgets_init', function() { register_widget( 'TocWidgetItem' ); });