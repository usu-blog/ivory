<?php /* Template Name: 検索結果 */

get_header(); ?>

<div id="contents-wrapper" class="w-100 max-w-100 pa-4">
  <main id="main" class="w-100" role="main">
    <h1 id="h1" class="headline mb-4" data-text-align="center"><?php the_title(); ?></h1>
    <?php echo google_custom_search_result(); ?>
  </main>
</div>

<?php
get_sidebar();
get_footer();
