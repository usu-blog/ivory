<!DOCTYPE html>
<!--
Theme Name: 4536
Theme URI: https://4536.jp
-->
<?php
if (is_amp()) {
    get_template_part('template-parts/head-setting-amp');
} else {
    get_template_part('template-parts/head-setting');
}
?>
<body id="body" data-display="flex" data-flex-direction="column" data-flex-wrap="nowrap" data-position="relative" <?php body_class(); ?>>
  <div id="main-column" class="flex">

    <?php

    if (is_amp()) {
        if (!empty(amp_add_html_js_body())) {
            echo amp_add_html_js_body();
        }
        get_template_part('template-parts/google-analytics');
    }

    $header_class = (fixed_header() && !has_header_image()) ? ' fixed-header' : '';

    if (!none_header_footer()) { ?>

      <div id="site-top" class="gradation wave-shape-outline" data-position="relative">
        <header id="header" class="header header-section<?php echo $header_class; ?>" itemscope itemtype="http://schema.org/WPHeader" role="banner">
          <?php get_template_part('template-parts/header-menu'); ?>
        </header>
        <?php

        //SVG
        wave_shape('header');

        ?>

      </div>

      <?php
      if (is_amp()) {
          dynamic_sidebar('amp-header');
          if (is_amp_header()) {
              echo amp_adsense_code('header');
          }
      } else {
          dynamic_sidebar('header-widget');
      }

    }

    if (is_singular()) {
        get_template_part('template-parts/post-title');
    } elseif(is_home() || is_front_page()) {
        media_section_4536('music');
    }

    ?>

    <div id="main-container" class="container w-100 ma-auto body-bg-color" data-display="flex" data-justify-content="center" data-position="relative">
