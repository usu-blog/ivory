<?php

class RelatedPostWidgetItem extends WP_Widget {

    public $_title = 'related_title';
    public $_count = 'related_count';
    public $_style = 'related_style';

    function __construct() {
		parent::__construct(
			'related_post',
			__( '(4536)関連記事', '4536' ),
			[ 'description' => __( '関連記事を出力します。', '4536' ) ]
		);
	}

    function widget($args, $instance) {
        if(!is_single() || is_singular(['music', 'movie'])) return;
        extract( $args );
        $title = apply_filters( 'widget_title', empty($instance[$this->_title]) ? '関連記事' : $instance[$this->_title] );
        $count = apply_filters( 'widget_related_count', $instance[$this->_count] );
        global $post;
        $g_count = 5;
        if(empty($count)) $count = $g_count;
        $categories = get_the_category($post->ID);
        $category_ID = [];
        foreach($categories as $category) {
            $category_ID[] = $category->cat_ID;
        }
        $default = [
            'post__not_in' => [$post->ID],
            'posts_per_page'=> $count,
            'category__in' => $category_ID,
            'orderby' => 'relevance',
        ];
        $related_posts = get_posts($default);
        if(!$related_posts) return;
        echo $args['before_widget'];
        if( !empty($title) ) echo $args['before_title'].$title.$args['after_title'];
        $thumbnail = $instance[$this->_style]==='thumbnail' ? null : '<i class="far fa-arrow-alt-circle-right"></i>';
        echo '<ul>';
        foreach($related_posts as $post) : setup_postdata( $post );
        widget_list_4536( $thumbnail );
        endforeach;
        wp_reset_postdata();
        echo '</ul>';

        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance[$this->_title] = strip_tags($new_instance[$this->_title]);
        $instance[$this->_count] = strip_tags($new_instance[$this->_count]);
        $instance[$this->_style] = $new_instance[$this->_style];
        return $instance;
    }

    function form($instance) {
        $title = $this->_title;
        $count = $this->_count;
        $style = $this->_style;
        $list = [
            'thumbnail' => 'サムネイルあり',
            'text' => 'サムネイルなし（テキストのみ）',
        ];
        ?>
        <p>
          <label for="<?php echo $this->get_field_id($title); ?>"><?php _e('関連記事のタイトル'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id($title); ?>" name="<?php echo $this->get_field_name($title); ?>" type="text" value="<?php echo esc_attr($instance[$title]); ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id($count); ?>"><?php _e('表示数'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id($count); ?>" name="<?php echo $this->get_field_name($count); ?>" type="number" value="<?php echo esc_attr($instance[$count]); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id($style); ?>"><?php _e( '表示スタイル' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id($style); ?>" name="<?php echo $this->get_field_name($style); ?>" type="text">
                <?php foreach($list as $name => $desc) { ?>
                <option value="<?php echo $name; ?>"<?php echo ($instance[$style]===$name) ? ' selected' : ''; ?>>
                    <?php echo $desc; ?>
                </option>
                <?php } ?>
            </select>
        </p>
    <?php }

}
add_action( 'widgets_init', function(){ register_widget( 'RelatedPostWidgetItem' ); });
