<?php
if(is_amp()) {
    ob_start();
    dynamic_sidebar('amp-fixed-footer');
    $amp_fixed_footer = ob_get_clean();
} else {
    ob_start();
    dynamic_sidebar('fixed-footer');
    $fixed_footer = ob_get_clean();
}

if( fixed_footer()==='floating_menu' && is_slide_menu() ) {
  echo '<div data-position="fixed" data-display="none-md" class="b-0 r-0 mr-3 mb-3"><label for="slide-toggle" data-button="floating" class="primary-bg-color">' .  icon_4536('menu', '#ffffff') . '</label></div>';
} elseif( fixed_footer()==='menu' ) { ?>
    <div id="fixed-footer-menu" data-display="none-md" data-justify-content="center" data-text-align="center" data-position="fixed" class="body-bg-color w-100 b-0 l-0 fixed-footer">
        <?php
        $list = [
            'home',
            'search',
            'share',
            'slide-menu',
            'top',
            'prev',
            'next',
        ];
        $common_class = ' pt-3 pb-2 l-h-140 post-color';
        $true = next_prev_in_same_term();
        foreach ($list as $name) {
          $class = '';
          $title = '';
          if(fixed_footer_menu_item($name) === true) {
            if($name === 'home') {
                if( is_home() || is_front_page() ) continue;
                $start_tag = '<a aria-label="ホームへ" data-display="block" class="fixed-footer-menu-item' . $common_class . '" href="'.home_url().'">';
                $end_tag = '</a>';
                $icon = 'home';
                $title = 'ホーム';
            } elseif($name === 'search') {
                if(is_amp() && !is_ssl()) continue;
                $start_tag = '<label data-display="block" class="fixed-footer-menu-item' . $common_class . '" for="search-toggle">';
                $end_tag = '</label>';
                $icon = 'search';
                $title = '検索';
                $class = ' search-button';
            } elseif($name === 'share') {
                $start_tag = '<label data-display="block" class="fixed-footer-menu-item' . $common_class . '" for="share-menu-toggle">';
                $end_tag = '</label>';
                $icon = 'share';
                $title = 'シェア';
                $class = ' fixed-share-toggle-button';
            } elseif( $name === 'slide-menu' && is_slide_menu() ) {
                $start_tag = '<label data-display="block" class="fixed-footer-menu-item' . $common_class . '" for="slide-toggle">';
                $end_tag = '</label>';
                $icon = 'menu';
                $class = ' slide-button';
                $title = 'メニュー';
            } elseif($name === 'top') {
                $start_tag = '<a aria-label="ページトップに戻る" data-display="block" id="fixed-page-top-button" class="fixed-footer-menu-item' . $common_class . '" href="#">';
                $end_tag = '</a>';
                $icon = 'arrow_up';
                $class = ' fixed-page-top';
                $title = 'トップ';
            } elseif($name === 'prev') {
                if( !get_previous_post($true) || !is_single() ) continue;
                $start_tag = '<a aria-label="前の記事を見る" data-display="block" class="fixed-footer-menu-item' . $common_class . '" href="'.get_permalink(get_previous_post($true)->ID).'">';
                $end_tag = '</a>';
                $icon = 'arrow_left';
                $title = '前の記事';
            } elseif($name === 'next') {
                if( !get_next_post($true) || !is_single() ) continue;
                $start_tag = '<a aria-label="次の記事を見る" data-display="block" class="fixed-footer-menu-item' . $common_class . '" href="'.get_permalink(get_next_post($true)->ID).'">';
                $end_tag = '</a>';
                $icon = 'arrow_right';
                $title = '次の記事';
            } else {
              continue;
            }
          } else {
            continue;
          } ?>
          <div class="flex-1<?php echo $class; ?>">
              <?php echo $start_tag . icon_4536($icon, font_color(), 24); ?>
              <span data-display="block" class="meta"><?php echo $title; ?></span>
              <?php echo $end_tag; ?>
          </div>
        <?php } ?>
    </div>
<?php } elseif( fixed_footer()==='overlay' && !empty($fixed_footer) ) { ?>
    <div id="fixed-footer-overlay" data-display="none" data-justify-content="center" data-text-align="center" data-bg-color="white" data-color="white" data-position="fixed" class="fixed-footer w-100 b-0 l-0">
        <?php echo $fixed_footer; ?>
        <div class="close-button fixed-footer-close-button r-0 pa-1" data-position="absolute" data-bg-color="white">
          <?php echo icon_4536('close', font_color(), 24); ?>
        </div>
    </div>
<?php } elseif( fixed_footer()==='overlay' && !empty($amp_fixed_footer) ) { ?>
    <amp-sticky-ad layout="nodisplay">
        <?php echo $amp_fixed_footer; ?>
    </amp-sticky-ad>
<?php }
