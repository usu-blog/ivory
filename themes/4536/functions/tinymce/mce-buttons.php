<?php

//1段目に追加
add_filter( 'mce_buttons', function($buttons) {
    $add = [
        'wp_code',
        'table',
    ];
    return array_merge( $buttons, $add );
});

//2段目に追加
add_filter( 'mce_buttons_2', function($buttons) {
    $add = [];
    if(get_option('mce_button_searchreplace')) $add[] = 'searchreplace';
    if(get_option('mce_button_source_code')) $add[] = 'code';
    if(get_option('mce_button_balloon_left')) $add[] = 'balloon_left';
    if(get_option('mce_button_balloon_right')) $add[] = 'balloon_right';
    if(get_option('mce_button_balloon_think_left')) $add[] = 'balloon_think_left';
    if(get_option('mce_button_balloon_think_right')) $add[] = 'balloon_think_right';
    if(get_option('mce_button_point')) $add[] = 'point';
    if(get_option('mce_button_caution')) $add[] = 'caution';
    return array_merge( $buttons, $add );
});

//MCEボタン拡張
add_filter( 'mce_external_plugins', function($button) {
    $button['table'] = 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.13/plugins/table/plugin.min.js';
    $button['code'] = 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.13/plugins/code/plugin.min.js';
    $button['searchreplace'] = 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.13/plugins/searchreplace/plugin.min.js';
    $button['original_tinymce_button_plugin'] = get_template_directory_uri() . '/functions/tinymce/custom-visual-editor.js';
    return $button;
});

//古いエディタの吹き出し用カスタムデータ
add_action('admin_footer', function() {
    $user = wp_get_current_user();
    $avatar_left = get_avatar_url($user->ID);
    $avatar_right = get_avatar_url($user->ID);
    if(balloon_left_image()) $avatar_left = balloon_left_image();
    if(balloon_right_image()) $avatar_right = balloon_right_image();
    $user_name_left = $user->display_name;
    $user_name_right = $user->display_name;
    if(balloon_left_figcaption()!=='画像の説明') $user_name_left = balloon_left_figcaption();
    if(balloon_right_figcaption()!=='画像の説明') $user_name_right = balloon_right_figcaption();
    echo '<div id="visual-editor-avatar-left" data-avatar-left="'.$avatar_left.'" style="display:none;"></div>'.
    '<div id="visual-editor-avatar-right" data-avatar-right="'.$avatar_right.'" style="display:none;"></div>'.
    '<div id="visual-editor-user-name-left" data-user-name-left="'.$user_name_left.'" style="display:none;"></div>'.
    '<div id="visual-editor-user-name-right" data-user-name-right="'.$user_name_right.'" style="display:none;"></div>';
});
