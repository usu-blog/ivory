<?php
add_action('wp_head', function() {
    $google_font = (add_google_fonts()) ? 'https://fonts.googleapis.com/css?family='.add_google_fonts() : '';
    $font_awesome = fontawesome_url();
    $highlight_js = (is_highlight_js_4536()) ? '//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/agate.min.css' : '';
    $block_lib = wp_block_lib_stylesheet_url();
    if(!empty($google_font)) { ?>
    <link rel="preload" href="<?php echo $google_font; ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="<?php echo $google_font; ?>"></noscript>
    <?php } ?>
    <link rel="preload" href="<?php echo $font_awesome; ?>" as="style" onload="this.onload=null;this.rel='stylesheet'" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <noscript><link rel="stylesheet" href="<?php echo $font_awesome; ?>" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></noscript>
    <?php if($highlight_js) { ?>
    <link rel="preload" href="<?php echo $highlight_js; ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="<?php echo $highlight_js; ?>"></noscript>
    <?php }
    css_rel_preload_js();
});

function css_rel_preload_js() { ?>
<script>/*! loadCSS. [c]2017 Filament Group, Inc. MIT License */
(function(a){if(!a.loadCSS){a.loadCSS=function(){}}var b=loadCSS.relpreload={};b.support=(function(){var d;try{d=a.document.createElement("link").relList.supports("preload")}catch(f){d=false}return function(){return d}})();b.bindMediaToggle=function(e){var f=e.media||"all";function d(){e.media=f}if(e.addEventListener){e.addEventListener("load",d)}else{if(e.attachEvent){e.attachEvent("onload",d)}}setTimeout(function(){e.rel="stylesheet";e.media="only x"});setTimeout(d,3000)};b.poly=function(){if(b.support()){return}var d=a.document.getElementsByTagName("link");for(var e=0;e<d.length;e++){var f=d[e];if(f.rel==="preload"&&f.getAttribute("as")==="style"&&!f.getAttribute("data-loadcss")){f.setAttribute("data-loadcss",true);b.bindMediaToggle(f)}}};if(!b.support()){b.poly();var c=a.setInterval(b.poly,500);if(a.addEventListener){a.addEventListener("load",function(){b.poly();a.clearInterval(c)})}else{if(a.attachEvent){a.attachEvent("onload",function(){b.poly();a.clearInterval(c)})}}}if(typeof exports!=="undefined"){exports.loadCSS=loadCSS}else{a.loadCSS=loadCSS}}(typeof global!=="undefined"?global:this));</script>
<?php }
