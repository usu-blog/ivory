<?php
///////////////////////////////////////
//ページネーション（一覧ページ）と分割ページ（マルチページ）タグを出力
//参考：https://nelog.jp/rel-next-prev
///////////////////////////////////////
function rel_next_prev_link_4536() {
    if((!is_category() && !is_post_type_archive() && is_archive()) || is_search() || is_tag()) return;
    if(get_post_meta($post->ID, 'redirect', true)) return;
    if(get_post_meta($post->ID,'noindex',true)) return;
    if(is_single() || is_page()) {
        global $wp_query;
        $multipage = check_multi_page_4536();
        if($multipage[0] > 1) {
            $prev = generate_multipage_url_4536('prev');
            $next = generate_multipage_url_4536('next');
            if($prev) echo '<link rel="prev" href="'.$prev.'" />'.PHP_EOL;
            if($next) echo '<link rel="next" href="'.$next.'" />'.PHP_EOL;
        }
    } else {
        global $paged;
        if(get_previous_posts_link()) echo '<link rel="prev" href="'.get_pagenum_link( $paged - 1 ).'" />'.PHP_EOL;
        if(get_next_posts_link()) echo '<link rel="next" href="'.get_pagenum_link( $paged + 1 ).'" />'.PHP_EOL;
    }
}
if(is_rel_next_prev()) add_action( 'wp_head', 'rel_next_prev_link_4536' );

function generate_multipage_url_4536($rel='prev') {
    global $post;
    $url = '';
    $multipage = check_multi_page_4536();
    if($multipage[0] > 1) {
        $numpages = $multipage[0];
        $page = $multipage[1] == 0 ? 1 : $multipage[1];
        $i = 'prev' == $rel? $page - 1: $page + 1;
        if($i && $i > 0 && $i <= $numpages) {
            if(1 == $i) {
                $url = get_permalink();
            } else {
                if ('' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending'))) {
                    $url = add_query_arg('page', $i, get_permalink());
                } else {
                    $url = trailingslashit(get_permalink()).user_trailingslashit($i, 'single_paged');
                }
            }
        }
    }
    return $url;
}

//分割ページ（マルチページ）かチェックする
function check_multi_page_4536() {
    $num_pages    = substr_count(
        $GLOBALS['post']->post_content,
        '<!--nextpage-->'
    ) + 1;
    $current_page = get_query_var( 'page' );
    return array($num_pages, $current_page);
}