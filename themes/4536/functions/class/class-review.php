<?php
/**
 * Review JSON LD
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

namespace SHINOBI_WORKS;

/**
 * Review Class
 */
class Review {

	/**
	 * Constractor
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ] );
		add_action( 'transition_post_status', [ $this, 'save' ], 10, 3 );
		add_action( 'wp_head_4536', [ $this, 'script' ], 30 );
		add_filter( 'the_content', [ $this, 'add_rating_star_to_content' ], 1000 );
		add_filter( 'inline_style_4536', [ $this, 'style' ] );
	}

	/**
	 * Get Post Meta
	 *
	 * @param string $key is get_post_meta key.
	 */
	public function get_post_meta( $key ) {
		global $post;
		$value = get_post_meta( $post->ID, $key, true );
		if ( 'review_rating' === $key ) {
			// For Old Rating.
			if ( $value > 5 ) {
				$value = intval( $value ) / 2;
			}
		}
		return esc_html( $value );
	}

	/**
	 * Add Meta Box
	 */
	public function add_meta_box() {
		$title    = __( 'レビュー', '4536' );
		$id       = 'review';
		$callback = $id;
		add_meta_box( $id, $title, [ $this, $callback ], 'post', 'side', 'low' );
		add_meta_box( $id, $title, [ $this, $callback ], 'page', 'side', 'low' );
	}

	/**
	 * Save
	 *
	 * @param string $new_status is new post status.
	 * @param string $old_status is old post status.
	 * @param string $post       is post content.
	 */
	public function save( $new_status, $old_status, $post ) {
		switch ( $old_status ) {
			case 'auto-draft':
			case 'draft':
			case 'pending':
			case 'future':
				if ( 'publish' === $new_status ) {
					return $post;
				}
				break;
			default:
				add_action(
					'save_post',
					[ $this, 'post_meta_action' ]
				);
				break;
		}
	}

	/**
	 * Save Function Callback
	 *
	 * @param int $post_id .
	 */
	public function post_meta_action( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		if ( 'inline-save' === filter_input( INPUT_POST, 'action' ) ) {
			return $post_id;
		}
		$meta_key_arr = [
			'review_name',
			'review_rating',
			'review_type',
		];
		foreach ( $meta_key_arr as $meta_key ) {
			if ( filter_input( INPUT_POST, $meta_key ) ) {
				update_post_meta( $post_id, $meta_key, filter_input( INPUT_POST, $meta_key ) );
			} else {
				delete_post_meta( $post_id, $meta_key );
			}
		}
	}

	/**
	 * Callback Function
	 */
	public function review() {
		$review_name   = $this->get_post_meta( 'review_name' );
		$review_rating = $this->get_post_meta( 'review_rating' );
		$review_type   = $this->get_post_meta( 'review_type' );
		?>
		<p><small>この記事がレビュー記事の場合に「評価」と「レビュー対象の名前」を設定すると検索結果にレビュー項目が表示されることがあります。</small></p>
		<p>
			<label>レビュー対象の種類</label><br>
			<select name="review_type" type="text">
				<?php $selected = ( $review_type === $x ) ? ' selected' : ''; ?>
				<option value="" hidden>選択してください</option>
				<?php
				$review_type_arr = [
					'Product'    => '製品・サービス',
					'Restaurant' => 'レストラン（お店）',
				];
				foreach ( $review_type_arr as $type => $name ) {
					$selected = ( $review_type === $type ) ? ' selected' : '';
					echo '<option value="' . esc_attr( $type ) . '"' . esc_attr( $selected ) . '>'
							. esc_html( $name ) . '</option>';
				}
				?>
			</select>
		</p>
		<p><label>レビュー対象<input type="text" name="review_name" value="<?php echo esc_attr( $review_name ); ?>" size="60" class="input-4536" /></label></p>
		<label>評価</label><br>
		<select name="review_rating" type="text">
		<option value="" hidden>選択してください</option>
		<?php
		for ( $i = 2; $i <= 10; $i++ ) {
			$x        = strval( $i / 2 );
			$selected = ( strval( $review_rating ) === $x ) ? ' selected' : '';
			echo '<option value="' . esc_attr( $x ) . '"' . esc_attr( $selected ) . '>' . esc_html( $x ) . '</option>';
		}
		?>
		</select>
		<?php
	}

	/**
	 * Star
	 *
	 * @param string $color        is star color.
	 * @param string $rating_float is float value.
	 *
	 * @return string
	 */
	public function star( $color = '#cccccc', $rating_float = 0 ) {
		if ( 0 !== $rating_float ) {
			$gradient = <<< EOM1
<defs>
    <linearGradient id="gradient">
        <stop offset="0%" stop-color="{$color}" />
        <stop offset="50%" stop-color="{$color}" />
        <stop offset="50%" stop-color="#cccccc" />
    </linearGradient>
</defs>
EOM1;
			$fill     = 'url(#gradient)';
		} else {
			$gradient = '';
			$fill     = $color;
		}
		$star = <<< EOM
<svg xmlns="http://www.w3.org/2000/svg"
    width="32" height="32" viewBox="0 0 24 24" class="star">{$gradient}
    <path d="M12 17.27L18.18
    21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"
        stroke="none" fill="{$fill}"/>
</svg>
EOM;
		return $star;
	}

	/**
	 * Rating convert to star
	 *
	 * @param int $rating is rating value.
	 *
	 * @return string
	 */
	public function rating_value_to_star( $rating ) {
		if ( $rating < 1 || $rating > 5 ) {
			return;
		}
		$int   = intval( $rating );
		$blank = 5 - $int;
		$html  = str_repeat( $this->star( '#d56e0c' ), $int );
		if ( is_float( $rating ) ) {
			$html .= $this->star( '#d56e0c', 0.5 );
			$blank--;
		}
		if ( $blank > 0 ) {
			$html .= str_repeat( $this->star(), $blank );
		}
		return $html;
	}

	/**
	 * Add Rating Star To First Paragraph of Content
	 *
	 * @param string $content is post content.
	 *
	 * @return string
	 */
	public function add_rating_star_to_content( $content ) {
		$rating = $this->get_post_meta( 'review_rating' );
		$name   = $this->get_post_meta( 'review_name' );
		if ( ! $rating || ! $name ) {
			return $content;
		}
		if ( 1 < strlen( $rating ) ) {
			$rating = floatval( $rating );
		} else {
			$rating = intval( $rating );
		}
		$stars = $this->rating_value_to_star( $rating );

		$stars = '<p data-display="flex" data-align-items="center" data-font-size="x-large">評価：'
					. '<span id="review_rating_value">' . $rating . '</span>' . $stars . '</p>';
		return $stars . $content;
	}

	/**
	 * Script
	 */
	public function script() {
		$review_name   = $this->get_post_meta( 'review_name' );
		$review_rating = $this->get_post_meta( 'review_rating' );
		$review_type   = $this->get_post_meta( 'review_type' );
		if ( ! $review_type ) {
			$review_type = 'Thing';
		}
		if ( ! $review_name || ! $review_rating ) {
			return;
		}
		global $post;
		$posted_date = get_the_date( 'c' );
		$image_arr   = wp_get_attachment_image_src( get_post_thumbnail_id(), true );
		$image_url   = $image_arr[0];
		if ( 'LocalBusiness' === $review_type && ! $image_url ) {
			return;
		}
		$author         = get_userdata( $post->post_author )->display_name;
		$publisher_name = get_bloginfo( 'name' );
		// Here Document Begin.
		?>
<script type="application/ld+json">
{
	"@context": "http://schema.org",
	"@type": "Review",
	"itemReviewed": {
		"@type": "<?php echo esc_html( $review_type ); ?>",
		"name": "<?php echo esc_html( $review_name ); ?>",
		"image": "<?php echo esc_url( $image_url ); ?>",
		"review": {
			"author": {
				"@type": "Person"
			}
		}
	},
	"reviewRating": {
		"@type": "Rating",
		"ratingValue": "<?php echo esc_html( $review_rating ); ?>"
	},
	"datePublished": "<?php echo esc_html( $posted_date ); ?>",
	"author": {
		"@type": "Person",
		"name": "<?php echo esc_html( $author ); ?>"
	},
	"publisher": {
		"@type": "Organization",
		"name": "<?php echo esc_html( $publisher_name ); ?>"
	}
}
</script>
		<?php
	}

	/**
	 * Style
	 *
	 * @param array $css is css array.
	 *
	 * @return array
	 */
	public function style( $css ) {
		$css[] = '#review_rating_value{color:#d56e0c;margin-right:.5em;}';
		return $css;
	}

}
