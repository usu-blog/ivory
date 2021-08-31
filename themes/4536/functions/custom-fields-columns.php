<?php // 記事一覧にカスタムフィールドの値を表示する
function manage_posts_columns_4536($columns) {
	$columns['AMP'] = 'AMP';
	$columns['INDEX'] = 'INDEX';
	$columns['FOLLOW'] = 'FOLLOW';
	return $columns;
}
function add_posts_column_4536($column_name, $post_id) {
	if($column_name == 'AMP') {
        $status = get_post_meta($post_id, 'amp', true);
        echo ($status == 1) ? '無効' : '有効' ;
    }
	if($column_name == 'INDEX') {
        $status = get_post_meta($post_id, 'noindex', true);
        echo ($status == 1) ? '無効' : '有効' ;
    }
	if($column_name == 'FOLLOW') {
        $status = get_post_meta($post_id, 'nofollow', true);
        echo ($status == 1) ? '無効' : '有効' ;
    }
}
add_filter( 'manage_posts_columns', 'manage_posts_columns_4536' );
add_action( 'manage_posts_custom_column', 'add_posts_column_4536', 10, 2 );
add_filter( 'manage_pages_columns', 'manage_posts_columns_4536' );
add_action( 'manage_pages_custom_column', 'add_posts_column_4536', 10, 2 );

function column_orderby_custom_4536($vars) {
    if(isset($vars['orderby']) && $vars['orderby']=='AMP') {
        $vars = array_merge( $vars, [
            'meta_key' => 'amp',
            'orderby' => 'meta_value',
        ]);
    }
    if(isset($vars['orderby']) && $vars['orderby']=='INDEX') {
        $vars = array_merge( $vars, [
            'meta_key' => 'noindex',
            'orderby' => 'meta_value',
        ]);
    }
    if(isset($vars['orderby']) && $vars['orderby']=='FOLLOW') {
        $vars = array_merge( $vars, [
            'meta_key' => 'nofollow',
            'orderby' => 'meta_value',
        ]);
    }
    return $vars;
}
add_filter( 'request', 'column_orderby_custom_4536' );

function posts_register_sortable_4536($sortable_column) {
    $sortable_column['AMP'] = 'AMP';
    $sortable_column['INDEX'] = 'INDEX';
    $sortable_column['FOLLOW'] = 'FOLLOW';
    return $sortable_column;
}
add_filter( 'manage_edit-post_sortable_columns', 'posts_register_sortable_4536' );
add_filter( 'manage_edit-page_sortable_columns', 'posts_register_sortable_4536' );