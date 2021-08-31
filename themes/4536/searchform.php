<?php
$slug = '';
$query = 's';
$target = '';
if (search_style()==="google_custom_search") {
    $slug = google_custom_search_slug();
    $query = 'q';
}
if (is_amp() && is_ssl()) {
    $target = ' target="_top"';
}
if (is_amp() && !is_ssl()) {
    return;
} else { ?>
  <form data-display="flex" data-align-items="center" data-flex-wrap="nowrap" class="flex" role="search" method="get" action="<?php echo home_url() . '/' . $slug; ?>"<?php echo $target; ?>>
    <input type="search" value="<?php echo get_search_query(); ?>" name="<?php echo $query; ?>" id="<?php echo $query; ?>" placeholder="キーワード" aria-label="検索" class="flex pa-2 h-100" />
    <button type="submit" id="searchsubmit" aria-label="検索する" class="pa-2 ml-1 l-h-100">
      <?php echo icon_4536('search', font_color(), 24); ?>
    </button>
  </form>
<?php }
