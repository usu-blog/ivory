<?php
/**
 * Template Name: すべてのカテゴリと記事（HTMLサイトマップ）
 *
 * @package    WordPress
 * @category   Theme
 * @subpackage 4536
 * @author     Chef
 * @license    https://www.gnu.org/licenses/gpl-3.0.html/ GPL v2 or later
 * @link       https://4536.jp/
 * @since      1.0.0
 */

get_header(); ?>
<div id="contents-wrapper" class="w-100 max-w-100 pa-4">
<main id="main" class="w-100" role="main">
	<article id="html-sitemap" class="post">
	<div class="article-body">
		<?php
		$icon_note          = icon_4536( 'note', font_color(), 16 );
		$is_thumbnail       = get_post_meta( $post->ID, 'html_sitemap_thumbnail', true );
		$exclude_cat_id_arr = get_post_meta( $post->ID, 'html_sitemap_exclude_cat_id', true );
		$_orderby           = get_post_meta( $post->ID, 'html_sitemap_orderby', true );
		if ( ! $_orderby ) {
			$_orderby = 'date';
		}
		if ( ! empty( $exclude_cat_id_arr ) ) {
			$exclude_categories_id = '&exclude_tree=' . implode( ',', $exclude_cat_id_arr );
		} else {
			$exclude_cat_id_arr    = [];
			$exclude_categories_id = '';
		}
		$exclude_post_id = get_post_meta( $post->ID, 'html_sitemap_exclude_post_id', true );
		// @codingStandardsIgnoreStart
		echo apply_filters( 'the_content', $post->post_content );
		// @codingStandardsIgnoreEnd
		$categories = get_categories( 'parent=0' . $exclude_categories_id );
		foreach ( $categories as $category ) {
			echo '<section>';
			$_cat_id = $category->cat_ID;
			echo '<h2><a href="' . esc_url( get_category_link( $_cat_id ) ) . '">'
					. esc_html( $category->name ) . '</a></h2>';
			$thumbnail_arr = get_posts(
				[
					'post_type'      => 'post',
					'posts_per_page' => 1,
					'category'       => $_cat_id,
					'orderby'        => $_orderby,
				]
			);
			$_post_id      = $thumbnail_arr[0]->ID;
			if ( has_post_thumbnail( $_post_id ) && '1' === $is_thumbnail ) {
				echo '<figure class="mb-4" data-text-align="center">' . get_the_post_thumbnail( $_post_id, 'post-thumbnail', [ 'class' => 'category_thumbnail' ] ) . '</figure>';
			}
			$child_cat_arr  = get_terms(
				[
					'taxonomy' => 'category',
					'parent'   => $_cat_id,
				]
			);
			$exclude_cat_id = '';
			foreach ( $child_cat_arr as $child_cat ) {
				$exclude_cat_id .= ',-' . $child_cat->term_id;
			}
			$post_arr = get_posts(
				[
					'post_type'      => 'post',
					'posts_per_page' => -1,
					'category'       => [ $_cat_id . $exclude_cat_id ],
					'exclude'        => [ $exclude_post_id ],
					'orderby'        => $_orderby,
				]
			);
			foreach ( $post_arr as $_post ) {
				echo '<article data-display="flex" data-align-items="center" class="l-h-140 pb-2">'
						// @codingStandardsIgnoreStart
						. $icon_note
						// @codingStandardsIgnoreEnd
						. '<a class="ml-1 flex-1" href="' . esc_url( get_the_permalink( $_post->ID ) ) . '">'
						. esc_html( $_post->post_title ) . '</a></article>';
			}
			the_child_sitemap_4536( $_cat_id, 2, $exclude_cat_id_arr, $exclude_post_id, $_orderby );
			echo '</section>';
		}

		/**
		 * Echo the Child Sitemap
		 *
		 * @param int    $_cat_id is category id.
		 * @param int    $i is count.
		 * @param array  $exclude_cat_id_arr is exclude category id array.
		 * @param int    $exclude_post_id is exclude post id.
		 * @param string $_orderby is get_posts option.
		 */
		function the_child_sitemap_4536( $_cat_id, $i, $exclude_cat_id_arr = [], $exclude_post_id = null, $_orderby = 'date' ) {
			$icon_note     = icon_4536( 'note', font_color(), 16 );
			$child_cat_arr = get_terms(
				[
					'taxonomy' => 'category',
					'parent'   => $_cat_id,
				]
			);
			if ( ! empty( $child_cat_arr ) ) {
				$i++;
				if ( $i > 6 ) {
					$i = 6;
				}
				foreach ( $child_cat_arr as $child_cat ) {
					$child_cat_id = $child_cat->term_id;
					if ( in_array( $child_cat_id, $exclude_cat_id_arr, true ) ) {
						continue;
					}
					echo '<section class="children">';
					echo '<h' . esc_html( $i ) . '><a href="' . esc_url( get_category_link( $child_cat_id ) ) . '">'
							. esc_html( $child_cat->name ) . '</a></h' . esc_html( $i ) . '>';
					$exclude_cat_id  = '';
					$exclude_cat_arr = get_terms(
						[
							'taxonomy' => 'category',
							'parent'   => $child_cat_id,
						]
					);
					foreach ( $exclude_cat_arr as $obj ) {
						$exclude_cat_id .= ',-' . $obj->term_id;
					}
					$post_arr = get_posts(
						[
							'post_type'      => 'post',
							'posts_per_page' => -1,
							'category'       => [ $child_cat_id . $exclude_cat_id ],
							'exclude'        => [ $exclude_post_id ],
							'orderby'        => $_orderby,
						]
					);
					foreach ( $post_arr as $post ) {
						echo '<article data-display="flex" data-align-items="center" class="l-h-140 pb-2">'
								// @codingStandardsIgnoreStart
								. $icon_note
								// @codingStandardsIgnoreEnd
								. '<a class="ml-1 flex-1" href="' . esc_url( get_the_permalink( $post->ID ) ) . '">'
								. esc_html( $post->post_title ) . '</a></article>';
					}
					the_child_sitemap_4536( $child_cat_id, $i, $exclude_cat_id_arr, $exclude_post_id, $_orderby );
					echo '</section>';
				}
			}
		}
		?>
	</div>
	</article>
</main>
</div>
<?php
get_sidebar() . get_footer();
