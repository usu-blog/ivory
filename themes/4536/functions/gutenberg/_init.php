<?php

//エディター拡張
add_action( 'init', function() {
    // $path = get_parent_theme_file_uri() . '/functions/gutenberg/';
    $ver = (function_exists('theme_version_4536')) ? theme_version_4536() : '';
    wp_register_script( 'gutenberg-extention-4536', get_parent_theme_file_uri('dist/custom_block.js'), [ 'wp-blocks', 'wp-components', 'wp-element', 'wp-i18n', 'wp-editor' ], $ver );
    if(function_exists('register_block_type')) register_block_type( 'blocks/extention', [ 'editor_script' => 'gutenberg-extention-4536' ]);
});

//ブロックカテゴリー追加
add_filter('block_categories', function($categories) {
    $categories[] = [
        'slug'  => 'custom-block-4536',
        'title' => __('4536オリジナル'),
    ];
    return $categories;
});

//エディタの見た目を実際のサイトに近づける
add_action( 'enqueue_block_editor_assets', function() {

  if( !empty(add_google_fonts()) ) {
    wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Nunito'.add_google_fonts(), [], theme_version_4536() );
  }

  $css = add_inline_style_4536();
  wp_register_style( 'custom-gutenberg', false );
	wp_enqueue_style( 'custom-gutenberg' );
	wp_add_inline_style( 'custom-gutenberg', $css );

});

add_action( 'admin_print_styles', function() {
  $user = wp_get_current_user();
  $avatar = get_avatar_url($user->ID);
  $avatar_name = $user->display_name;
  echo '<div id="gutenberg-balloon-avatar" data-balloon-avatar="'.$avatar.'" style="display:none;"></div>'.
  '<div id="gutenberg-balloon-avatar-name" data-balloon-avatar-name="'.$avatar_name.'" style="display:none;"></div>';
});

//Gutenbergのデフォルトスタイルシートを違う場所で読み込む
add_action('wp_enqueue_scripts', function() {
    wp_dequeue_style( 'wp-block-library' );
});

//Gutenbergのスタイルシートをリンクにする
function wp_block_lib_stylesheet_url() {
    return includes_url('css/dist/block-library/style.min.css?'.get_bloginfo('version'));
}

//画像の幅広
add_theme_support( 'align-wide' );

//エディター拡張
class GutenbergEditorJS4536 {

	function __construct() {
        $list = [
            'editor_custom',
        ];
        foreach($list as $name) {
            add_action( 'admin_head-post.php', [$this, $name] );
            add_action( 'admin_head-post-new.php', [$this, $name] );
        }
	}

  function editor_custom() { ?>
    <script>
        window.addEventListener( 'DOMContentLoaded', function() {
            [].forEach.call(
              document.querySelectorAll( 'div.edit-post-visual-editor' ),
              e => e.classList.add( 'simple_bg_color', 'gradation_bg_color', 'simple_border_bottom', 'gradation_border_bottom', 'gradation_border_bottom2', 'simple_border_left', 'pop', 'cool', 'cool2', 'cool3', 'body-bg-color', 'post', 'article-body', 'post-color' )
            );
            // [].forEach.call(
            //   document.querySelectorAll( 'div.editor-writing-flow' ),
            //   e => e.classList.add( 'post', 'article-body', 'post-color' )
            // );
            [].forEach.call(
              document.querySelectorAll( 'textarea.editor-post-title__input' ),
              e => [
                e.classList.add( 'post-color' ),
                e.id = 'h1'
              ]
            );
        });
    </script>
  <?php }

}
new GutenbergEditorJS4536();
