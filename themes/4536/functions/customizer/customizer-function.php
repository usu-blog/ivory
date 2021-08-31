<?php

////////////////////////////////////
// デザイン
////////////////////////////////////
//固定ヘッダー
function fixed_header() {
    return get_theme_mod( 'fixed_header', false );
}
//関連記事の表示数
function related_post_count() {
    $count = get_theme_mod( 'related_post_count', 10 );
    if (empty($count)) $count = 0;
    return mb_convert_kana(strip_tags($count), 'n');
}
//固定フッター
function fixed_footer() {
    return get_theme_mod( 'fixed_footer', 'floating_menu' );
}
//固定フッターメニュー
function fixed_footer_menu_item($name) {
    return get_theme_mod( 'fixed_footer_menu_'.$name, true );
}
////////////////////////////////////
// ページ設定
////////////////////////////////////
//Googleフォント追加
function add_google_fonts() {
    return esc_html(get_theme_mod( 'add_google_fonts', null ));
}
//Googleフォント適用箇所
function is_google_fonts() {
    return get_theme_mod( 'is_google_fonts', null );
}
//前後記事リンクを同じカテゴリだけに
function next_prev_in_same_term() {
    return get_theme_mod( 'next_prev_in_same_term', null );
}
//この記事を書いた人、記事ページ
function is_profile_4536($post_type) {
    return get_theme_mod( $post_type, true );
}
//前後の記事
function post_prev_next_4536() {
    return get_theme_mod( 'post_prev_next', true );
}
////////////////////////////////////
// 検索機能
////////////////////////////////////
//検索機能切り替え
function search_style() {
    return get_theme_mod( 'search_style', null );
}
//Googleカスタム検索結果のコード
function google_custom_search_result() {
    return get_theme_mod( 'google_custom_search_result', null );
}
//Googleカスタム検索のスラッグ
function google_custom_search_slug() {
    return esc_html(get_theme_mod( 'google_custom_search_slug', null ));
}
////////////////////////////////////
// SNS
////////////////////////////////////
//Twitterカード
function twitter_card() {
    return get_theme_mod( 'twitter_card', 'summary' );
}
//Twitterのvia
function twitter_via() {
    return get_theme_mod( 'twitter_via', true );
}
////////////////////////////////////
// SEO
////////////////////////////////////
//Googleアナリティクス
function google_analytics() {
    return esc_html(get_option('google_analytics_tracking_id'));
}
//プレビュー時にもカウント
function google_analytics_preview_count() {
    return get_option('google_analytics_preview_count');
}
//ログインユーザーもカウント
function google_analytics_logged_in_user_count() {
    return get_option('google_analytics_logged_in_user_count');
}
//OGP設定
function is_ogp() {
    return get_option('admin_ogp');
}
//トップページのSEO対策
function seo_setting_home() {
    return get_option('admin_seo_home');
}
//トップページのメタディスクリプションの文字
function custom_home_description() {
    return esc_html(get_option('admin_home_description'));
}
//記事単位のSEO対策
function seo_setting_post() {
    return get_option('admin_seo_post');
}
//アーカイブページのSEO対策
function seo_setting_archive() {
    return get_option('admin_seo_archive');
}
//canonical
function is_rel_canonical() {
    return get_option('admin_canonical');
}
//rel_next_prev
function is_rel_next_prev() {
    return get_option('admin_next_prev');
}
//トップページのキーワード設定
function top_keywords() {
    return esc_html(get_option('admin_home_keyword'));
}
////////////////////////////////////
// AMP
////////////////////////////////////
//記事ページ有効
function is_amp_post_type($post_type) {
    if($post_type==='single') return get_option('admin_amp');
    else return get_option('is_amp_'.$post_type);
}
//アドセンスコード取得
function get_amp_adsense_code() {
    return get_option('admin_amp_adsense_code');
}
//アドセンスタイトル
function amp_ad_title() {
    return esc_html(get_option('admin_amp_adsense_title'));
}
//ヘッダーアドセンス
function is_amp_header() {
    return get_option('admin_amp_adsense_header');
}
//記事上アドセンス
function is_amp_post_top() {
    return get_option('admin_amp_adsense_post_top');
}
//記事中アドセンス
function is_amp_before_1st_h2() {
    return get_option('admin_amp_adsense_h2');
}
//記事下アドセンス
function is_amp_post_bottom() {
    return get_option('admin_amp_adsense_post_bottom');
}
//新着記事上アドセンス
function is_amp_sidebar_top() {
    return get_option('admin_amp_adsense_sidebar');
}
//head内にコード追加
function amp_add_html_js_head() {
    return get_option('admin_amp_add_html_js_head');
}
//body直後にコード追加
function amp_add_html_js_body() {
    return get_option('admin_amp_add_html_js_body');
}
///////////////////////////////////
// コメント設定
///////////////////////////////////
//コメント欄の表示
function is_comments($post_type) {
    $default = ($post_type==='is_comments_page') ? false : true ;
    return get_theme_mod( $post_type, $default );
}
//E-mailの表示
function comments_email() {
    return get_theme_mod( 'comments_email', true );
}
//ウェブサイトの表示
function comments_website() {
    return get_theme_mod( 'comments_website', true );
}
//ウェブサイトの表示
function comments_cookies() {
    return get_theme_mod( 'comments_cookies', true );
}
//「メールアドレスが公開されることはありません」の表示
function comments_mail_address_text() {
    return get_theme_mod( 'comments_mail_address_text', true );
}
////////////////////////////////////
// 目次
////////////////////////////////////
function is_toc() {
    return get_theme_mod( 'is_toc', null );
}
function toc_headline_level() {
    return get_theme_mod( 'toc_headline_level', null );
}
function toc_headline_count() {
    return get_theme_mod( 'toc_headline_count', 3 );
}
function toc_title() {
    return esc_html(get_theme_mod( 'toc_title', '目次' ));
}
////////////////////////////////////
// ソースコードハイライト表示
////////////////////////////////////
function is_code_highlight() {
    return get_theme_mod( 'is_code_highlight', null );
}
function code_highlight_category() {
    return explode(',', esc_html(get_theme_mod( 'code_highlight_category', null )));
}
////////////////////////////////////
// 追加 HTML&JS
////////////////////////////////////
function add_html_js_head() {
    return get_option('admin_add_html_js_head');
}
function add_html_js_body() {
    return get_option('admin_add_html_js_body');
}
////////////////////////////////////
// 吹き出し
////////////////////////////////////
//左figcaption
function balloon_left_figcaption() {
    return esc_html(get_theme_mod( 'balloon_left_figcaption', '画像の説明' ));
}
//右figcaption
function balloon_right_figcaption() {
    return esc_html(get_theme_mod( 'balloon_right_figcaption', '画像の説明' ));
}
//左からの吹き出し画像
function balloon_left_image() {
    return esc_url( get_theme_mod( 'balloon_left_image' ) );
}
//右からの吹き出し画像
function balloon_right_image() {
    return esc_url( get_theme_mod( 'balloon_right_image' ) );
}
//吹き出し画像のサイズ
function balloon_image_size() {
    return get_theme_mod( 'balloon_image_size', '60' );
}
//吹き出し画像のサイズ
function balloon_image_style_option() {
    return get_theme_mod( 'balloon_image_style_option', 'border_border_radius' );
}
////////////////////////////////////
// その他
////////////////////////////////////
//JavaScriptの読み込み方法
function javascript_load() {
    return get_theme_mod( 'javascript_load', null );
}
//オリジナルブログカード
function custom_blogcard() {
    return get_theme_mod( 'custom_blogcard', false );
}
//コピーガード
function copy_guard() {
    return get_theme_mod( 'copy_guard', false );
}
//カエレバタグ変換
function kaereba_convert() {
    return get_theme_mod( 'kaereba_convert', 'amp' );
}
//カエレバデザイン
function kaereba_design() {
    return get_theme_mod( 'kaereba_design', 'amp' );
}
//ウィジェットの自動タグ追加機能無効
function is_widget_wpautop() {
    return get_theme_mod( 'is_widget_wpautop', true );
}
////////////////////////////////////
// WordPress自動更新設定
////////////////////////////////////
//メジャーアップデート更新設定
function wordpress_major_update_setting() {
    return get_option('admin_wordpress_major_update');
}
//マイナーアップデート更新設定
function wordpress_minor_update_setting() {
    return get_option('admin_wordpress_minor_update');
}
//開発版アップデート更新設定
function wordpress_dev_update_setting() {
    return get_option('admin_wordpress_dev_update');
}
//プラグインアップデート更新設定
function wordpress_plugin_update_setting() {
    return get_option('admin_wordpress_plugin_update_setting');
}
//テーマアップデート更新設定
function wordpress_theme_update_setting() {
    return get_option('admin_wordpress_theme_update');
}
//翻訳アップデート更新設定
function wordpress_translation_update_setting() {
    return get_option('wordpress_translation_update');
}
////////////////////////////////////
// 既存の項目に追加
////////////////////////////////////
//ヘッダーのロゴ
function header_logo_url() {
    return esc_url(get_theme_mod('header_logo_url'));
}
//サイトタイトルの変更
function site_title() {
    return esc_html(get_theme_mod( 'site_title', null ));
}
