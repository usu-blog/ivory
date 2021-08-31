<?php

if( layout_4536() === 'center-content' ) return;

$my_sidebar = my_sidebar();
$sidebar = $my_sidebar['sidebar'];
$scroll_sidebar = $my_sidebar['scroll_sidebar'];

if( empty($sidebar) && empty($scroll_sidebar) ) return;

$is_slide_menu = is_slide_menu();

?>
<div id="sidebar" class="pa-4">
  <?php
  if( $is_slide_menu ) { ?>
    <input id="slide-toggle" type="checkbox" data-display="none">
    <label id="slide-mask" for="slide-toggle" class="mask t-0 l-0 r-0 b-0" data-display="none" data-position="fixed" data-bg-color="black"></label>
    <div id="slide-menu" class="t-0 r-0 h-100">
      <label for="slide-toggle" data-display="none-md" data-justify-content="center" data-align-items="center" class="flex close-button pa-4 mb-4"><?php echo icon_4536('close', font_color(), 24); ?>CLOSE</label>
  <?php }
  if( is_amp() && is_amp_sidebar_top() ) echo amp_adsense_code('sidebar');
  if( !empty($sidebar) ) echo '<aside class="sidebar-inner" role="complementary">' . $sidebar . '</aside>';
  if( !empty($scroll_sidebar) ) echo '<aside id="scroll-sidebar" class="sidebar-inner" role="complementary">' . $scroll_sidebar . '</aside>';
  if( $is_slide_menu ) echo '</div>';
  ?>
</div>
