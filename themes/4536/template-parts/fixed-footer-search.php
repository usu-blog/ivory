<?php
if(fixed_footer()!=='menu') return;
if(empty(fixed_footer_menu_item('search'))) return;
?>
<div id="fixed-search-contents">
    <input id="search-toggle" type="checkbox" data-display="none">
    <label id="search-mask" for="search-toggle" class="mask t-0 b-0 r-0 l-0" data-position="fixed" data-bg-color="black" data-display="none"></label>
    <div id="fixed-search" data-display="none" class="pa-4 b-0 r-0 l-0" data-bg-color="white">
        <div id="fixed-search-form">
            <?php get_search_form(); ?>
        </div>
        <label for="search-toggle" data-display="flex" data-justify-content="center" data-align-items="center" class="flex close-button pt-4"><?php echo icon_4536('close', font_color(), 24); ?>CLOSE</label>
    </div>
</div>
