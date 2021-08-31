<?php

class CtaWidgetItem extends WP_Widget
{
    public $button_parts = [
    'title',
    'src',
    // 'image_style',
    'description',
    'button_text',
    'button_url',
    'button_text_url',
  ];

  //   public $button_args = [
  //   'button_color',
  //   'button_reflection',
  //   'button_bounce',
  //   'button_text_shadow',
  // ];

    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'scripts']);
        parent::__construct(
            'cta',
            __('(4536)CTA', '4536')
        );
    }

    public function widget($args, $instance)
    {
        foreach ($this->button_parts as $key) {
            ${$key} = !empty($instance[$key]) ? $instance[$key] : '';
        }
        $title = apply_filters('widget_title', $title);
        // $button_args = [];
        // $button_args[] = 'button-4536';
        // foreach ($this->button_args as $key) {
        //     if (!empty($instance[$key])) {
        //         $button_args[] = $instance[$key];
        //     }
        // }
        // $button_args = implode(' ', $button_args);
        if (empty($button_text) && empty($button_url) && empty($button_text_url)) {
            return;
        }
        // preg_match( '/header-widget/', $args['before_widget'], $match );
        // if( !empty( $match ) ) {
        //   $wrap = str_replace( $match[0], $match[0] . ' d-f', $args['before_widget'] );
        //   $wrap_class = 'flex';
        // } else {
        //   $wrap = $args['before_widget'];
        //   $wrap_class = 'padding-10px';
        // }
        // $wrap = str_replace( 'widget-4536', 'widget-4536 ' . $wrap_class, $wrap );
        echo $args['before_widget']; ?>

    <div data-display="flex" data-justify-content="center" data-align-items="center" data-flex-direction="row-reverse" class="gradation">
      <?php if (!empty($src)) {
            // $image_margin = ( $image_style !== 'aligncenter' ) ? ' max-width-half-pc' : '';
            $size = get_image_width_and_height_4536($src);
            if (!empty($size['width'])) {
                $width = 'width="'.$size['width'].'"';
            }
            if (!empty($size['height'])) {
                $height = ' height="'.$size['height'].'"';
            }
            $image = '<img class="cta-image" src="' . $src . '" ' . $width . $height . ' alt />';
            $image = lazy_load_media_4536( $image );
            $thumbnail = '<figure class="xs12 sm12 md6">' . $image . '</figure>';
            echo convert_content_to_amp($thumbnail);
        } ?>
      <div class="content xs12 sm12 md6 pt-5 pb-5 pr-4 pl-4">
        <?php if (!empty($title)) {
            echo '<div class="cta-title headline mb-4 l-h-160" data-text-align="center" data-font-size="xx-large">'.$title.'</div>';
        }

        if (!empty($description)) {
            echo '<div class="mb-4 l-h-140">' . $description . '</div>';
        }
        if (!empty($button_text_url)) {
            $button = '<div data-button="submit" class="outline">' . $button_text_url . '</div>';
        }
        if (!empty($button_text) && !empty($button_url)) {
            $target = is_my_website($button_url) ?  '' : ' target="_blank" rel="nofollow noopener"';
            $attribute = ( !empty($button_text_url) ) ? 'data-font-size="small" data-text-decoration="underline" class="pa-3"' : ' data-button="submit" class="outline"';
            $button .= '<a href="'.$button_url.'"' . $target . $attribute . '>'.$button_text.'</a>';
        }
        if (!empty($button)) {
            $button = '<div data-display="flex" data-align-items="center" data-justify-content="center" data-flex-direction="row-reverse" class="mt-5 l-h-160">' . $button . '</div>';
            echo convert_content_to_amp($button);
        } ?>
      </div>
    </div>

  <?php
  echo $args['after_widget'];
    }

    public function update($new_instance, $old_instance)
    {
        foreach ($this->button_parts as $key) {
            $instance[$key] = !empty($new_instance[$key]) ? $new_instance[$key] : '';
        }
        // foreach ($this->button_args as $key) {
        //     $instance[$key] = !empty($new_instance[$key]) ? $new_instance[$key] : '';
        // }
        return $instance;
    }

    public function form($instance) { ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('タイトル'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>">
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('src'); ?>"><?php _e('画像'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('src'); ?>" name="<?php echo $this->get_field_name('src'); ?>" type="text" value="<?php echo esc_url($instance['src']); ?>" />
      <button class="upload-image-button button button-primary">選択</button>
      <button class="delete-image-button button">削除</button>
      <img class="widefat" src="<?php echo esc_url($instance['src']); ?>" style="margin:1em 0;display:block;">
    </p>
    <!-- <p>
      <label for="<?php echo $this->get_field_id('image_style'); ?>"><?php _e('画像の表示位置（PC）'); ?></label>
      <select class="widefat" id="<?php echo $this->get_field_id('image_style'); ?>" name="<?php echo $this->get_field_name('image_style'); ?>" type="text">
        <?php
        $arr = [
          'aligncenter' => '中央',
          'alignleft' => '左寄せ',
          'alignright' => '右寄せ',
        ];
        foreach ($arr as $key => $value) {
            $selected = $instance['image_style'] === $key ? ' selected' : '';
            echo '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
        } ?>
      </select>
    </p> -->
    <p>
      <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('説明文'); ?></label>
      <textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php echo esc_textarea($instance['description']); ?></textarea>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('button_text'); ?>"><?php _e('ボタンの文字'); ?></label>
      <?php
      // $content   = esc_attr($instance['button_text']);
      // $editor_id = $this->get_field_id('button_text');
      // $editor_id = str_replace( '-', '_', $editor_id );
      // $settings = [
      //   'media_buttons' => false,
      //   'textarea_rows' => 3,
      //   'teeny'         => true,
      //   'tinymce'       => false,
      //   'textarea_name' => $this->get_field_name('button_text'),
      // ];
      // wp_editor( $content, $editor_id, $settings );
      ?>
      <input class="widefat" id="<?php echo $this->get_field_id('button_text'); ?>" name="<?php echo $this->get_field_name('button_text'); ?>" type="text" value="<?php echo esc_attr($instance['button_text']); ?>" placeholder="例：詳細はこちら" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('button_url'); ?>"><?php _e('URL（リンク）'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('button_url'); ?>" name="<?php echo $this->get_field_name('button_url'); ?>" type="text" value="<?php echo esc_url($instance['button_url']); ?>" placeholder="例：https://example.com" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('button_text_url'); ?>"><?php _e('ボタンのテキストリンク'); ?></label>
      <?php $placeholder = 'アフィリエイトのコードなどを貼り付けてください。ここに入力されたものがボタンとして優先的に使われます。'; ?>
      <textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('button_text_url'); ?>" name="<?php echo $this->get_field_name('button_text_url'); ?>" placeholder="<?php echo $placeholder; ?>"><?php echo esc_textarea($instance['button_text_url']); ?></textarea>
    </p>
    <!-- <p>
      <label for="<?php echo $this->get_field_id('button_color'); ?>"><?php _e('ボタンの色'); ?></label>
      <select class="widefat" id="<?php echo $this->get_field_id('button_color'); ?>" name="<?php echo $this->get_field_name('button_color'); ?>" type="text">
        <?php
        $arr = [
          'background-color-orange' => 'オレンジ',
          'background-color-green' => '緑',
          'background-color-blue' => '青',
          'background-color-red' => '赤',
          'background-color-black' => '黒',
        ];
        foreach ($arr as $key => $value) {
            $selected = $instance['button_color'] === $key ? ' selected' : '';
            echo '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
        } ?>
      </select>
    </p> -->
    <!-- <p>
      <label><input class="widefat" name="<?php echo $this->get_field_name('button_reflection'); ?>" value="is-reflection" <?php checked($instance['button_reflection'], 'is-reflection');?> type="checkbox"><?php _e('ボタンを光らせる'); ?></label>
    </p>
    <p>
      <label><input class="widefat" name="<?php echo $this->get_field_name('button_bounce'); ?>" value="is-bounce" <?php checked($instance['button_bounce'], 'is-bounce');?> type="checkbox"><?php _e('ボタンをバウンドさせる'); ?></label>
    </p>
    <p>
      <label><input class="widefat" name="<?php echo $this->get_field_name('button_text_shadow'); ?>" value="text-shadow-4536" <?php checked($instance['button_text_shadow'], 'text-shadow-4536');?> type="checkbox"><?php _e('ボタンの文字に影をつける'); ?></label>
    </p> -->
    <?php
  }

    public function scripts()
    {
        wp_enqueue_script('media-upload');
        wp_enqueue_media();
        wp_enqueue_script('media-uploader', get_template_directory_uri() . '/functions/widgets/media-uploader.js', ['jquery']);
    }
}
add_action('widgets_init', function () {
    register_widget('CtaWidgetItem');
});
