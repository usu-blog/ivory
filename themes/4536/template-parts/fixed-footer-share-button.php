<?php
if(fixed_footer()!=='menu') return;
if(empty(fixed_footer_menu_item('share'))) return;
?>
<div id="fixed-footer-share-menu-contents">
    <input id="share-menu-toggle" type="checkbox" data-display="none">
    <label id="share-menu-mask" for="share-menu-toggle" class="mask t-0 b-0 r-0 l-0" data-position="fixed" data-bg-color="black" data-display="none"></label>
    <div id="fixed-footer-menu-sns" class="pa-4 b-0 r-0 l-0" data-bg-color="white" data-display="none">
        <?php sns_button_4536(); ?>
        <label for="share-menu-toggle" data-display="flex" data-justify-content="center" data-align-items="center" class="flex close-button pt-4"><?php echo icon_4536('close', font_color(), 24); ?>CLOSE</label>
    </div>
</div>
