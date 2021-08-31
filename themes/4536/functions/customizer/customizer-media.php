<?php

add_action('customize_register', function ($wp_customize) {

		//メディア設定
    $wp_customize->add_section('media', [
    'title' => 'メディア関連',
    'description' => '<span style="font-weight:bold">※4536の画像表示に関しての詳細は<a href="https://4536.jp/image-thumbnail" target="_blank" >こちら</a></span>',
    'priority' => 20,
]);

    //レイジーロード
    $wp_customize->add_setting('is_lazy_load', [
            'default' => false,
    ]);
    $wp_customize->add_control('is_lazy_load', [
            'section' => 'media',
            'settings' => 'is_lazy_load',
            'label' =>'レイジーロード',
            'description' => '画像（img）とYouTubeなどの動画（iframe）を遅延読み込みします。詳細は<a href="https://4536.jp/lazy-load" target="_blank" >こちらのページ</a>をご覧ください。',
            'type' => 'checkbox',
    ]);

    //サムネイル画像の縦横の比率
    $wp_customize->add_setting('thumbnail_size', [
        'default' => 'thumbnail-wide',
    ]);
    $wp_customize->add_control('thumbnail_size', [
        'section' => 'media',
        'settings' => 'thumbnail_size',
        'label' => 'サムネイル（記事一覧の画像）の縦と横の比率',
        'type' => 'radio',
        'choices' => [
            'thumbnail-wide' => '横長（デフォルト）',
            'thumbnail' => '正方形',
        ],
    ]);
    //サムネイルの画質
    $wp_customize->add_setting('thumbnail_quality', [
        'default' => null,
    ]);
    $wp_customize->add_control('thumbnail_quality', [
        'section' => 'media',
        'settings' => 'thumbnail_quality',
        'label' => 'サムネイルの画質',
        'description' => '画質が高くなるほどキレイに表示されますが、若干読み込み速度は下がります。',
        'type' => 'radio',
        'choices' => [
            null => '最適化（デフォルト）',
            'high' => '高画質',
        ],
    ]);
    //アイキャッチ画像の取得方法
    $wp_customize->add_setting('get_post_first_image', [
        'default' => 'get_save',
    ]);
    $wp_customize->add_control('get_post_first_image', [
        'section' => 'media',
        'settings' => 'get_post_first_image',
        'label' =>'サムネイルに使用する画像',
        'type' => 'select',
        'choices' => [
            'get_save' => '記事中最初の画像またはYouTube動画を表示（アイキャッチ画像として保存）',
            'get' => '記事中最初の画像を使用（アイキャッチ画像として保存しない）',
            'original' => 'あらかじめアイキャッチ画像をアップロードしてセットする',
            null => 'アイキャッチ画像を設定しない場合はテーマ側の画像を使用',
        ],
    ]);
    //オリジナルのサムネイル
    $wp_customize->add_setting('original_thumbnail');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'original_thumbnail', [
        'section' => 'media',
        'settings' => 'original_thumbnail',
        'label' => 'オリジナルのサムネイル',
    ]));

});

//サムネイルの比率
function thumbnail_size()
{
    return get_theme_mod('thumbnail_size', 'thumbnail-wide');
}
//サムネイルの画質
function thumbnail_quality()
{
    return get_theme_mod('thumbnail_quality', null);
}
//サムネの表示方法
function get_post_first_image()
{
    return get_theme_mod('get_post_first_image', 'get_save');
}
//オリジナルのアイキャッチ画像
function original_thumbnail_url()
{
    return esc_url(get_theme_mod('original_thumbnail'));
}
//レイジーロード
function is_lazy_load_4536()
{
    return get_theme_mod('is_lazy_load', false);
}
