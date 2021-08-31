<?php

class PickupPostWidgetItem extends WP_Widget {

    public $_title = 'pickup_title';
    public $_count = 'pickup_count';
    public $_tag = 'pickup_tag';

    function __construct() {
		parent::__construct(
			'pickup_post',
			__( '(4536)ピックアップ記事', '4536' ),
			['description' => __( '特定のタグがある記事をサムネイルありで表示します', '4536' )]
		);
	}

    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters( 'widget_title', empty($instance[$this->_title]) ? 'ピックアップ記事' : $instance[$this->_title] );
        $tag = apply_filters( 'widget_pickup_tag', $instance[$this->_tag] );
        $count = apply_filters( 'widget_pickup_count', $instance[$this->_count] );
        if(empty($tag)) return;
        global $post;
        $g_count = 5;
        if(empty($count)) $count = $g_count;
        $default = [
            'posts_per_page' => $count,
            'orderby' => 'relevance',
            'post__not_in' => [$post->ID],
            'tag' => $tag,
        ];
        $pickupPosts = get_posts($default);
        if(!$pickupPosts) return;
        echo $args['before_widget'];
        if(!empty($title)) echo $args['before_title'].$title.$args['after_title'];
        echo '<ul>';
        foreach($pickupPosts as $post) : setup_postdata( $post );
        widget_list_4536();
        endforeach;
        wp_reset_postdata();
        echo '</ul>';
        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance[$this->_title] = strip_tags($new_instance[$this->_title]);
        $instance[$this->_tag] = strip_tags($new_instance[$this->_tag]);
        $instance[$this->_count] = strip_tags($new_instance[$this->_count]);
        return $instance;
    }

    function form($instance) {
        $title = $this->_title;
        $count = $this->_count;
        ?>
        <p>
          <label for="<?php echo $this->get_field_id($title); ?>"><?php _e('タイトル'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id($title); ?>" name="<?php echo $this->get_field_name($title); ?>" type="text" value="<?php echo esc_attr($instance[$title]); ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id($count); ?>"><?php _e('表示数'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id($count); ?>" name="<?php echo $this->get_field_name($count); ?>" type="number" value="<?php echo esc_attr($instance[$count]); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id($title); ?>"><?php _e('表示する記事のタグ'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id($this->_tag); ?>" name="<?php echo $this->get_field_name($this->_tag); ?>" type="text">
                <option value="">選択してください</option>
                <?php foreach(get_terms('post_tag') as $tag) { ?>
                <option value="<?php echo $tag->name; ?>"<?php echo ($instance[$this->_tag]===$tag->name) ? ' selected' : ''; ?>>
                    <?php echo $tag->name; ?>
                </option>
                <?php } ?>
            </select>
        </p>
    <?php }

}
add_action( 'widgets_init', function() { register_widget( 'PickupPostWidgetItem' ); });
