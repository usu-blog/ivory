<?php

global $page, $paged, $post;

if(is_home()||is_front_page()) { // ホーム
    $canonical_url = home_url();

} elseif(is_category()) { // カテゴリーページ
    $canonical_url = get_category_link(get_query_var('cat'));

} elseif(is_post_type_archive()) { // カスタム投稿タイプ
    $canonical_url = get_post_type_archive_link($post_type);

} elseif(is_singular()) { // 固定ページ＆個別記事
    $canonical_url = get_permalink();
    $url = get_post_meta($post->ID, 'canonical', true);
    if($url) $canonical_url = $url;
    $noindex = get_post_meta($post->ID,'noindex',true);
    if($noindex) $canonical_url = null;
    $url = get_post_meta($post->ID, 'redirect', true);
    if($url) $canonical_url = null;

} else { // その他
    $canonical_url = null;
}

if($canonical_url && ( $paged >= 2 || $page >= 2)) {
    $canonical_url = $canonical_url.'/page/'.max( $paged, $page ).'';
}

if($canonical_url == !null) echo '<link rel="canonical" href="'.$canonical_url.'" />';