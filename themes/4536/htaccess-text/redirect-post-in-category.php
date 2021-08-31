<?php

$redirect_settings = redirect_post_in_category_settings();
$rewrite_array = [];

$my_site_url = preg_replace( '/https?\:\/\//', '', site_url() );
preg_match( '/\/(.+[^\/])/', $my_site_url, $sub_dir );
$sub_dir = ( !empty($sub_dir[1]) ) ? '\/'.$sub_dir[1] : '';

for ($i=0; $i < redirect_count(); $i++) {
	$rewrite_cond = [];
	$redirect_type = ( $redirect_settings['redirect_check_302'][$i] === '1' ) ? '302' : '301' ;
	$site_url = esc_url( $redirect_settings['redirect_url'][$i] );
	if( empty($site_url) ) $site_url = false;
	$cat_id_array = $redirect_settings['cat_id'][$i];
	$cat_id_array = array_filter( $cat_id_array );
	$cat_id = ( is_array($cat_id_array) ) ? implode( ',', $cat_id_array ) : false;
	if( strpos( $cat_id, '-' ) !== false ) $cat_id = false;
	if( empty($cat_id) ) $cat_id = false;
	if( $site_url===false || $cat_id===false ) continue;
	$args = [
		'posts_per_page' => -1,
		'category' => $cat_id,
	];
	$posts_array = get_posts( $args );
	foreach ( $posts_array as $post_info ) {
	  $slug = $post_info->post_name;
	  $rewrite_cond[] = 'RewriteCond %{REQUEST_URI} ^'.$sub_dir.'\/'.preg_quote($slug).'\/?$ [OR]';
	}
	$rewrite_cond = implode( PHP_EOL, $rewrite_cond );
	$rewrite_cond = rtrim( $rewrite_cond, ' [OR]' );
	if( empty($rewrite_cond) ) continue;
	$rewrite_cond = $rewrite_cond.PHP_EOL.'RewriteCond %{REQUEST_URI} !(\/category\/.)';
	$rewrite_cond = $rewrite_cond.PHP_EOL.'RewriteCond %{REQUEST_URI} !(\/tag\/.)';
	$site_url = rtrim( $site_url, '/' ) . '/';
	$rewrite = $rewrite_cond.PHP_EOL.'RewriteRule ^([^\/]+?)?$ '.preg_quote($site_url, '/').'$1 [R='.$redirect_type.',L]';
	$rewrite = '#setting_no_'.$i.'_begin'.PHP_EOL.$rewrite.PHP_EOL.'#setting_no_'.$i.'_end';
	$rewrite_array[] = $rewrite;
}

if ( empty($rewrite_array) ) {
	return;
} else {
	update_option( 'is_enable_redirect_post_in_category', '1' );
}

$rewrite = implode( PHP_EOL, $rewrite_array );

// var_dump($rewrite);

$text = <<< EOM
#4536RedirectPostInCategoryBegin
<IfModule mod_rewrite.c>
RewriteEngine On
{$rewrite}
</IfModule>
#4536RedirectPostInCategoryEnd
EOM;

echo $text;
