<?php /* Template Name: シンプルなデザイン */
get_header(); ?>
<div id="contents-wrapper" class="w-100 max-w-100 pa-4">
  <main id="main" class="w-100" role="main">
    <article class="post">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <h1 id="h1" class="headline mb-4"><?php the_title(); ?></h1>
      <?php
       if ( !get_post_meta($post->ID, 'none_post_thumbnail', true) ) {
           the_post_thumbnail();
       }
      ?>
      <div class="article-body mt-4">
        <?php the_content(); ?>
      </div>
      <?php endwhile; endif; ?>
    </article>
  </main>
</div>
<?php get_sidebar().get_footer();
