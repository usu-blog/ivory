<?php get_header(); ?>
<div id="contents-wrapper" class="w-100 max-w-100 pa-4">
  <main id="main" class="w-100" role="main">
    <?php get_template_part('template-parts/post');
    if (is_amp()) {
        if (is_active_sidebar('amp-post-bottom')) {
            dynamic_sidebar('amp-post-bottom');
        }
    } else {
        if (is_active_sidebar('post-bottom')) {
            dynamic_sidebar('post-bottom');
        }
    }
    if (is_singular('post')) {
        get_template_part('template-parts/related-post');
        if (is_comments('is_comments_single') && (comments_open() || get_comments_number())) {
            comments_template();
        }
        get_template_part('template-parts/page-nav');
        // echo breadcrumb('html');
    } elseif (is_singular(['music', 'movie'])) {
        if (is_comments('is_comments_media') && (comments_open() || get_comments_number())) {
            comments_template();
        }
    } elseif (is_page()) {
        if (is_comments('is_comments_page') && (comments_open() || get_comments_number())) {
            comments_template();
        }
    }
    // get_template_part('template-parts/follow-box');
    media_section_4536('pickup');
    ?>
  </main>
</div>
<?php
get_sidebar();
get_footer();
