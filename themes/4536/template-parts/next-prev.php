<?php
global $page, $paged, $wp_query, $max_page;

// 2ページ目以降がある場合
// rel="next" href="～" を出力
if (!$max_page) $max_page = $wp_query->max_num_pages;

if (!$paged)
    $paged = 1;
    $nextpage = intval($paged) + 1;

if (!is_singular() && ($nextpage <= $max_page)) { ?>
<link rel="next" href="<?php echo next_posts( $max_page, false ); ?>" />
<?php } /* end if */

// rel="prev" href="～" を出力
if(!is_singular() && $paged > 1) { ?>
<link rel="prev" href="<?php echo previous_posts( false ); ?>" />
<?php } /* end if */ ?>