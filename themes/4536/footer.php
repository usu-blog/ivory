<?php

echo '</div>'; //#main-container

if (!is_home() || !is_front_page()) {
    media_section_4536('music');
}

media_section_4536('movie'); //サブメディア

if (!is_amp() && is_active_sidebar('footer') && !none_header_footer()) { ?>
  <div id="footer-widget-container" class="container ma-auto mt-5">
    <div data-display="flex" data-justify-content="center">
      <?php dynamic_sidebar('footer'); ?>
    </div>
  </div>
<?php }


echo '</div>'; //#main-column

?>

<div id="site-bottom" class="gradation wave-shape-outline" data-position="relative">
  <div data-position="relative">
    <?php wave_shape('footer'); ?>
    <a class="page-top t-50 r-0 mr-3" href="#body" data-button="floating" data-bg-color="white" data-position="absolute" aria-label="ページトップへ戻る">
      <?php echo icon_4536('arrow_up', '', 36); ?>
    </a>
  </div>
  <footer id="footer" class="footer" itemscope itemtype="http://schema.org/WPFooter" role="contentinfo">
    <div class="container ma-auto">
      <?php
      $defaults = [
        'theme_location'  => 'navbar_footer',
        'container' => false,
        'fallback_cb' => false,
        'echo' => false,
        'items_wrap' => '<ul data-display="flex" data-justify-content="center">%3$s</ul>',
      ];
      if (has_nav_menu('navbar_footer')) {
          echo '<div class="global-nav pa-3">' . wp_nav_menu($defaults) . '</div>';
      }?>
      <div id="copyright" data-text-align="center" class="meta pt-3 pb-5 pr-3 pl-3">
        <?php
        $name = (site_title()) ? site_title() : get_bloginfo('name');
        $link = '<a href="'.home_url().'">'.$name.'</a>';
        ?>
        <span>Copyright&copy;&nbsp;<?php echo $link; ?>,&nbsp;<?php the_date('Y'); ?>&nbsp;All&nbsp;Rights&nbsp;Reserved.</span>
      </div>
      <?php
      if (fixed_footer() && !none_header_footer()) {
          echo '<div data-display="none-md" class="pb-5"></div>';
      } ?>
    </div>
  </footer>
</div>

<?php
if (!none_header_footer()) {
          get_template_part('template-parts/fixed-footer');
          get_template_part('template-parts/fixed-footer-share-button');
          get_template_part('template-parts/fixed-footer-search');
          if (!is_amp()) {
              wp_footer();
              if (add_html_js_body()) {
                  echo add_html_js_body();
              }
          }
      } else {
          if (!is_amp()) {
              wp_footer();
          }
      }
echo '</body></html>';
