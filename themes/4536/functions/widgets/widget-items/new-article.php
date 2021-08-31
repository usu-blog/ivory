<?php

class NewEntryWidgetItem extends WP_Widget {

    public $_title = 'new_title';
    public $_count = 'new_count';

    function __construct() {
		parent::__construct(
			'new_post',
			__( '(4536)新着記事', '4536' ),
			[ 'description' => __( 'サムネイルありの新着記事を表示します（トップページでは非表示）', '4536' ) ]
		);
	}

    function widget($args, $instance) {
      global $post;
        extract( $args );
        $title = apply_filters( 'widget_title', empty($instance[$this->_title]) ? '新着記事' : $instance[$this->_title] );
        $count = apply_filters( 'widget_entry_count', $instance[$this->_count] );
        if(empty($count)) $count = 5;
        $default = [
            'posts_per_page' => $count,
            'post__not_in' => [$post->ID],
        ];
        $new_posts = get_posts($default);
        if(!$new_posts) return;
        global $post;
        echo $args['before_widget'];
        if($title) echo $args['before_title'].$title.$args['after_title'];
        ?>
        <ul>
          <?php
          foreach($new_posts as $post) : setup_postdata( $post );
          widget_list_4536();
          endforeach;
          wp_reset_postdata();
          ?>
        </ul>
        <?php
        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance[$this->_title] = strip_tags($new_instance[$this->_title]);
        $instance[$this->_count] = strip_tags($new_instance[$this->_count]);
        return $instance;
    }

    function form($instance) {
        $title = $this->_title;
        $count = $this->_count;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id($title); ?>"><?php _e('新着記事のタイトル'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id($title); ?>" name="<?php echo $this->get_field_name($title); ?>" type="text" value="<?php echo esc_attr($instance[$title]); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id($count); ?>"><?php _e('表示数'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id($count); ?>" name="<?php echo $this->get_field_name($count); ?>" type="number" value="<?php echo esc_attr($instance[$count]); ?>" />
        </p>
        <?php
    }

}
add_action( 'widgets_init', function() { register_widget( 'NewEntryWidgetItem' ); });

//参考：https://nelog.jp/theme-widget
