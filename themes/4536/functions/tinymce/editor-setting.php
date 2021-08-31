<?php

//TinyMCEエディタの拡張
add_filter('before_wp_tiny_mce', function($init) {
    ob_start();
    require_once( TEMPLATEPATH . '/css/inline.min.css');
    $admin_style_color = ob_get_clean();
    $css = $admin_style_color.add_inline_style_4536();
    $css = str_replace('.article-body', '', $css );
    $css .= 'html{height:auto}';
    if( get_option('first_tinymce_active_editor') && !get_user_option('rich_editing') ) { ?>
    <script>
        $(function() {
            if(!tinyMCE.activeEditor) $('.wp-editor-wrap .switch-tmce').trigger('click');
        })
    </script>
    <?php } ?>
    <script>
        $(window).load(function() {
            tinyMCE.activeEditor.dom.addStyle( <?php echo json_encode($css); ?> );
        });
    </script>
<?php });

//クラスやIDを追加
add_filter( 'tiny_mce_before_init', function($initArray) {
	$initArray['body_id'] = 'primary'; // id
	$initArray['body_class'] = 'edit-post-visual-editor post simple_bg_color gradation_bg_color simple_border_bottom gradation_border_bottom gradation_border_bottom2 simple_border_left pop cool cool2 cool3'; // class
	return $initArray;
});

//管理画面にCSS追加
add_action( 'after_setup_theme', function() {
    add_editor_style( 'style.css' ); //メインのCSS
    $custom_font = (add_google_fonts()) ? '|'.add_google_fonts() : '';
    $font_url[] = '//fonts.googleapis.com/css?family=Nunito'.$custom_font;
    $font_url[] = '//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css';
    $font_url = str_replace( ',', '%2C', $font_url );
    add_editor_style( $font_url );
});
