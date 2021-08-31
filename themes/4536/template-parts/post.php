<?php

if (is_amp() && is_amp_post_top()) {
    echo amp_adsense_code('post_top');
}

if (is_amp()) {
    dynamic_sidebar('amp-post-top');
} else {
    dynamic_sidebar('post-top-widget');
}

if (is_singular('post')) {
    $is_profile = is_profile_4536('profile_single');
} elseif (is_page()) {
    $is_profile = is_profile_4536('profile_page');
} elseif (is_singular(['music', 'movie'])) {
    $is_profile = is_profile_4536('profile_media');
} else {
    $is_profile = false;
}

if (have_posts()) : while (have_posts()) : the_post();

echo '<article class="post article-body">';

$content = apply_filters('the_content', get_the_content());
$content = str_replace(']]>', ']]&gt;', $content);
if (is_amp() && empty($content)) {
    echo '<p>'.auto_description_4536().'</p>'.
        '<div class="to-mobile-page button-4536 background-color-orange">'.
        '<a class="color-white-4536" href="'.get_the_permalink().'">続きを読む</a></div>';
} else {
    the_content();
    wp_link_pages();
}

echo '</article>';

if (is_amp() && is_amp_post_bottom()) {
    echo amp_adsense_code('post_bottom');
}

//記事下広告枠
if (is_amp()) {
    if (is_active_sidebar('amp-post-ad')) {
        $ad = 'amp-post-ad';
    }
} else {
    if (is_active_sidebar('ad')) {
        $ad = 'ad';
    }
}
if (isset($ad) && !empty($ad)) {
    dynamic_sidebar($ad);
}

//記事下

$term = [];
if (has_category() && is_single()) {
    $categories = get_the_category();
    if (!empty($categories)) {
        foreach ($categories as $category) {
            $term_cat[] = '<a class="post-color" href="' . get_category_link($category->term_id) . '">' . $category->cat_name . '</a>';
        }
        $category = '<div id="post-bottom-category" data-display="flex"><span>カテゴリー：</span>' . implode('<span class="mr-1">,</span>', $term_cat) . '</div>';
    } else {
        $category = '';
    }
}
if (has_tag()) {
    $tags = get_the_tags();
    if (!empty($tags)) {
        foreach ($tags as $tag) {
            $term_tag[] = '<a class="post-color" href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a>';
        }
        $tag = '<div id="post-bottom-tag" data-display="flex"><span>タグ：</span>' . implode('<span class="mr-1">,</span>', $term_tag) . '</div>';
    } else {
        $tag = '';
    }
}

?>

<hr class="section-break mt-5" />
<div id="post-bottom-section" class="l-h-160" data-display="flex" data-align-items="center">
  <?php
  if (!empty($category) || !empty($tag)) { ?>
    <?php
    echo '<div id="post-term-section" class="meta mt-4 mb-4" data-display="flex" data-flex-direction="column">' . $category . $tag . '</div>';
  }
  echo '<div class="flex"></div>';
  sns_button_4536('flex-end');
  ?>
</div>
<hr class="section-break mb-5" />

<?php

endwhile; else:

echo '<p>記事がありません</p>';

endif;

wp_reset_postdata();

if( $is_profile === true ) get_template_part('template-parts/profile');
