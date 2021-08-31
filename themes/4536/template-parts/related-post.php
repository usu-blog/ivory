<?php

if(empty(related_post_count())) return;

$categories = get_the_category($post->ID);
$category_ID = [];
foreach($categories as $category) {
    $category_ID[] = $category->cat_ID;
}

$args = [
    'post__not_in' => [get_the_ID()],
    'posts_per_page'=> related_post_count(),
    'category__in' => $category_ID,
    'orderby' => 'relevance',
];
$related_posts = get_posts($args);

if(!$related_posts) return;

?>

<aside id="related-post" class="pt-5">
  <h2 data-text-align="center" class="mt-3 mb-3 headline">関連記事</h2>
  <div data-display="flex" data-justify-content="center">
    <?php
    foreach( $related_posts as $post ) : setup_postdata( $post );
    post_list_card_4536('h3');
    endforeach;
    wp_reset_postdata();
    ?>
  </div>
</aside>
