<?php
/**
 * SNS Button
 *
 * @package    WordPress
 * @category   Theme
 * @subpackage 4536
 * @author     Chef
 * @license    https://www.gnu.org/licenses/gpl-3.0.html/ GPL v2 or later
 * @link       https://4536.jp/
 * @since      1.0.0
 */

/**
 * SNS Button Functions
 *
 * @param string $justify_content is justyfi content value.
 */
function sns_button_4536( $justify_content = 'center' ) {
	if ( is_amp() || is_singular() ) {
		$url    = esc_url( get_permalink() );
		$title  = esc_html( get_the_title() );
		$custom = get_post_custom();
		if ( ! empty( $custom['sns_title'][0] ) ) {
			$title = esc_html( $custom['sns_title'][0] );
		}
	} else {
		$http  = is_ssl() ? 'https://' : 'http://';
		$url   = esc_url( $http . filter_input( INPUT_SERVER, 'HTTP_HOST' ) . filter_input( INPUT_SERVER, 'REQUEST_URI' ) );
		$title = esc_html( wp_get_document_title() );
	}

	$via = ( twitter_via() && get_the_author_meta( 'twitter' ) ) ? '&via=' . get_the_author_meta( 'twitter' ) : '';

	$target = ( is_amp() ) ? ' rel="nofollow"' : ' target="blank" rel="nofollow"';

	// URL.
	$arr['twitter']['url']  = 'http://twitter.com/share?text=' . $title . '&url=' . $url . $via . '&tw_p=tweetbutton&related=' . get_the_author_meta( 'twitter' );
	$arr['facebook']['url'] = 'http://www.facebook.com/sharer.php?src=bm&u=' . $url . '&t=' . $title;
	$arr['hatebu']['url']   = 'http://b.hatena.ne.jp/add?mode=confirm&url=' . $url;
	$arr['line']['url']     = 'http://line.me/R/msg/text/?' . $title . '%0A' . $url;

	// Text.
	$arr['twitter']['icon']   = I_TWITTER;
	$arr['twitter']['title']  = 'ツイッターでシェアする';
	$arr['facebook']['icon']  = I_FACEBOOK;
	$arr['facebook']['title'] = 'フェイスブックでシェアする';
	$arr['hatebu']['icon']    = I_HATEBU;
	$arr['hatebu']['title']   = 'はてなブックマークでシェアする';
	$arr['line']['icon']      = I_LINE;
	$arr['line']['title']     = 'ラインでシェアする';

	// Share Count.
	if ( function_exists( 'scc_get_share_twitter' ) && scc_get_share_twitter() !== 0 ) {
		$arr['twitter']['count'] = '<span class="meta pl-1">' . scc_get_share_twitter() . '</span>';
	} else {
		$arr['twitter']['count'] = '';
	}
	if ( function_exists( 'scc_get_share_facebook' ) && scc_get_share_facebook() !== 0 ) {
		$arr['facebook']['count'] = '<span class="meta pl-1">' . scc_get_share_facebook() . '</span>';
	} else {
		$arr['facebook']['count'] = '';
	}
	if ( function_exists( 'scc_get_share_hatebu' ) && scc_get_share_hatebu() !== 0 ) {
		$arr['hatebu']['count'] = '<span class="meta pl-1">' . scc_get_share_hatebu() . '</span>';
	} else {
		$arr['hatebu']['count'] = '';
	}
	$arr['line']['count'] = '';
	?>

	<div data-display="flex" data-justify-content="<?php echo esc_attr( $justify_content ); ?>" class="flex">
		<?php
		foreach ( $arr as $key => $value ) {
			$title      = $value['title'];
			$aria_label = $title;
			$count      = $value['count'] ? $value['count'] : '';
			echo '<span class="pt-2 pb-2 pr-3 pl-3">' .
					'<a aria-label="' . esc_attr( $aria_label ) . '"' .
					'title="' . esc_attr( $title ) . '" class="l-h-100 ' . esc_attr( $key ) . '"' .
					'href="' . esc_url( $value['url'] ) . '"' . esc_attr( $target ) . '>' .
					// @codingStandardsIgnoreStart
					$value['icon'] .
					// @codingStandardsIgnoreEnd
					'</a>' . esc_html( $count ) . '</span>';
		}
		?>
	</div>

	<?php
} ?>
