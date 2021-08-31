<?php
function auto_description_4536() {
  $content = get_post(get_the_ID())->post_content;
  $content = custom_excerpt_4536( $content, 160 );
  return $content;
}
function description_4536() {
    if(is_home()) {
        $description = (custom_home_description()) ? custom_home_description() : get_bloginfo('description') ;
    } elseif(is_singular() || is_front_page()) { // 記事ページ
        //カスタムフィールドで設定したディスクリプション
        $custom_description = get_post_meta(get_the_ID(), 'description', true);
        $custom_description = custom_excerpt_4536( $custom_description, 160 );
        //条件によって読み込むディスクリプションを変更
        $description = ( !empty($custom_description) ) ? $custom_description : auto_description_4536() ;
    } elseif(is_category()) { // カテゴリーページ
        if(term_description()) { //カテゴリーの説明を入力している場合
            $description = term_description();
        } else { //カテゴリーの説明がない場合
            $description = single_cat_title('', false).'の記事一覧';
        }
    } elseif(is_tag()) { // タグページ
        if(term_description()) { //タグの説明を入力している場合
            $description = term_description();
        } else { //タグの説明がない場合
            $description = single_tag_title('', false).'の記事一覧';
        }
    } elseif(is_day()) {
         $description = get_the_time('Y年m月d日').'の記事一覧';
    } elseif(is_month()) {
        $description = get_the_time('Y年m月').'の記事一覧';
    } elseif(is_year()) {
        $description = get_the_time('Y年').'の記事一覧';
    } elseif(is_author()) {
        $description = get_queried_object()->display_name.'の記事一覧';
    }
    if($description) return esc_html($description);
}
