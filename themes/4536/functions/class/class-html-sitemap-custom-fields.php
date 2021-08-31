<?php
/**
 * HTML Sitemap Custom Field
 *
 * @package    WordPress
 * @category   Theme
 * @subpackage 4536
 * @author     Chef
 * @license    https://www.gnu.org/licenses/gpl-3.0.html/ GPL v2 or later
 * @link       https://4536.jp/
 * @since      1.0.0
 */

declare( strict_types = 1 );

/**
 * HTML Sitemap Class
 */
class Html_Sitemap_Custom_Fields {

	/**
	 * Constractor
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ] );
		add_action( 'transition_post_status', [ $this, 'save' ], 10, 3 );
	}

	/**
	 * Get Post Meta
	 *
	 * @param string $key is get_post_meta key.
	 */
	public function get_post_meta( string $key ) {
		global $post;
		$value = get_post_meta( $post->ID, $key, true );
		return esc_html( $value );
	}

	/**
	 * Add Meta Box
	 */
	public function add_meta_box() {
		$title    = __( 'HTMLサイトマップ設定', '4536' );
		$id       = 'html_sitemap_setting';
		$callback = $id;
		add_meta_box(
			$id,
			$title,
			[ $this, $callback ],
			'page',
			'side',
			'default'
		);
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
		// is_thumbnail.
		if ( filter_input( INPUT_POST, 'html_sitemap_thumbnail' ) ) {
			update_post_meta( $post_id, 'html_sitemap_thumbnail', filter_input( INPUT_POST, 'html_sitemap_thumbnail' ) );
		} else {
			delete_post_meta( $post_id, 'html_sitemap_thumbnail' );
		}
		// Exclude Post ID.
		if ( filter_input( INPUT_POST, 'html_sitemap_exclude_post_id' ) ) {
			// @codingStandardsIgnoreStart
			$data = mb_convert_kana( strip_tags( filter_input( INPUT_POST, 'html_sitemap_exclude_post_id' ) ), 'n' );
			// @codingStandardsIgnoreEnd
			$data = preg_replace( '/[^0-9,]/', '', $data );
			$data = trim( $data, ',' );
			update_post_meta( $post_id, 'html_sitemap_exclude_post_id', $data );
		} else {
			delete_post_meta( $post_id, 'html_sitemap_exclude_post_id' );
		}
		// Exclude Category ID.
		$_cat_id_arr = filter_input(
			INPUT_POST,
			'html_sitemap_exclude_cat_id',
			FILTER_VALIDATE_INT,
			FILTER_REQUIRE_ARRAY
		);
		if ( $_cat_id_arr ) {
			update_post_meta(
				$post_id,
				'html_sitemap_exclude_cat_id',
				$_cat_id_arr
			);
		} else {
			delete_post_meta( $post_id, 'html_sitemap_exclude_cat_id' );
		}
		if ( filter_input( INPUT_POST, 'html_sitemap_orderby' ) ) {
			update_post_meta( $post_id, 'html_sitemap_orderby', filter_input( INPUT_POST, 'html_sitemap_orderby' ) );
		} else {
			delete_post_meta( $post_id, 'html_sitemap_orderby' );
		}
	}

	/**
	 * Callback Function
	 */
	public function html_sitemap_setting() {
		global $post;
		$html_sitemap_thumbnail       = $this->get_post_meta( 'html_sitemap_thumbnail' );
		$html_sitemap_exclude_post_id = $this->get_post_meta( 'html_sitemap_exclude_post_id' );
		$html_sitemap_exclude_cat_id  = get_post_meta( $post->ID, 'html_sitemap_exclude_cat_id', true );
		$html_sitemap_orderby         = $this->get_post_meta( 'html_sitemap_orderby' );
		?>
		<p>
			<label>
				<input type="checkbox" name="html_sitemap_thumbnail" value="1"<?php checked( $html_sitemap_thumbnail, 1 ); ?>>
				カテゴリー画像を表示する
			</label>
		</p>
		<p>
			<label>
				<input type="checkbox" name="html_sitemap_orderby" value="modified"<?php checked( $html_sitemap_orderby, 'modified' ); ?>>
				更新日順に記事を表示する
			</label>
		</p>
		<p>
			<label>除外記事ID（複数指定時はカンマ区切り）<br />
				<input type="text" name="html_sitemap_exclude_post_id" value="<?php echo esc_html( $html_sitemap_exclude_post_id ); ?>"
					size="60" class="input-4536" placeholder="例：11,222,3333">
			</label>
		</p>
		<p style="margin-bottom:0;">除外カテゴリー</p>
		<ul style="height:auto;max-height:150px;overflow-y:scroll;margin:0;background-color:#fcfcfc;padding:.5em;display:inline-block;box-sizing:border-box;">
			<?php
			$walker = new Walker_Category_Checklist_Widget( 'html_sitemap_exclude_cat_id' );
			wp_category_checklist( 0, 0, $html_sitemap_exclude_cat_id, false, $walker, false );
			?>
		</ul>
		<?php
	}

}
