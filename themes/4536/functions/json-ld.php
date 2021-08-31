<?php
/**
 * JSON LD
 *
 * PHP Version >= 5.6
 *
 * @package    WordPress
 * @category   Theme
 * @subpackage 4536
 * @author     Chef
 * @license    https://www.gnu.org/licenses/gpl-3.0.html/ GPL v2 or later
 * @link       https://4536.jp/
 * @since      1.0.0
 */

add_action(
	'wp_head_4536',
	function () {
		global $post;
		if ( ! is_singular() ) {
			return;
		}
		$image_id = get_post_thumbnail_id();
		if ( empty( $image_id ) ) {
			return;
		}
		$image_url     = wp_get_attachment_image_src( $image_id, true );
		$author        = get_userdata( $post->post_author )->display_name;
		$posted_date   = get_the_date( 'c' );
		$modified_date = get_the_modified_date( 'c' ); ?>
<script type="application/ld+json">
{
	"@context": "http://schema.org",
	"@type": "Article",
	"mainEntityOfPage": {
		"@type": "WebPage",
		"@id": "<?php the_permalink(); ?>"
	},
	"headline": "<?php the_title(); ?>",
	"datePublished": "<?php echo esc_html( $posted_date ); ?>",
	"dateModified": "<?php echo esc_html( $modified_date ); ?>",
	"image": ["<?php echo esc_url( $image_url[0] ); ?>"],
	"author": {
		"@type": "Person",
		"name": "<?php echo esc_html( $author ); ?>"
	},
	"publisher": {
		"@type": "Organization",
		"name": "<?php echo bloginfo( 'name' ); ?>",
		"logo": {
			"@type": "ImageObject",
			"url": "<?php echo esc_url( get_site_icon_url() ); ?>",
			"width": 32,
			"height": 32
		}
	},
	"description": "<?php echo esc_html( description_4536() ); ?>"
}
</script>
		<?php
	}
);
