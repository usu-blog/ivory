<?php
/**
 * Add a CSS throw the 'inline_style_4536' filter.
 *
 * @category Theme
 * @package WordPress
 * @author Shinobi Works <support@shinobiworks.com>
 * @link https://shinobiworks.com/
 * @todo If I had enough time, I could update the 4536 theme 😇
 */

add_filter(
	'inline_style_4536',
	function ( $css ) {
		global $post;
		$content = wpautop( $post->post_content );

		// Googleフォント
		if ( add_google_fonts() ) {
			$css[] = is_google_fonts() . '{font-family:"' . add_google_fonts() . '" !important}';
		}

		// 吹き出し
		if ( balloon_image_style_option() === 'border_border_radius' ) { // 吹き出し画像を丸くする
			$css[] = '.balloon figure img{border:1px solid #aaa;border-radius:50%}';
		}
		switch ( balloon_image_size() ) {
			case '60':
				$css[] = '.balloon-image-left,.balloon-image-right{width:60px}';
				break;
			case '80':
				$css[] = '.balloon-image-left,.balloon-image-right{width:80px}.balloon-text-right,.balloon-text-left{max-width:-webkit-calc(100% - 140px);max-width:calc(100% - 140px)}';
				break;
			case '100':
				$css[] = '.balloon-image-left,.balloon-image-right{width:100px}.balloon-text-right,.balloon-text-left{max-width:-webkit-calc(100% - 160px);max-width:calc(100% - 160px)}';
				break;
		}

		// 画像の比率
		$height = ( thumbnail_size() === 'thumbnail' ) ? '100' : '56.25';
		$css[]  = ".post-thumbnail{padding-top:$height%}";

		//
		// ここから先は管理画面に不要 /////
		//
		if ( is_admin() ) {
			return $css;
		}

		// プライマリーカラー
		$primary_color = primary_color();
		$css[]         = ".primary-bg-color{background-color:$primary_color}";
		// $css[] = ".primary_color{color:$primary_color}";

		// セカンダリーカラー
		$secondary_color = secandary_color();
		$css[]           = ".sub-menu .menu-item{background-color:$secondary_color}";

		// グラデーション
		$gradation = gradation_color();
		$css[]     = ".gradation{ $gradation }";
		$css[]     = '.gradation a{color:#ffffff}.header-slide-icon{fill:#ffffff}';

		// 背景色
		$bg_color = get_bg_color_4536();
		$css[]    = ".wave-shape-outline::before,.wave-shape-outline::after{border:2px solid $bg_color;}";

		// シェイプグラデーション
		$light_color = 'rgba(' . hex_to_rgb( $secondary_color ) . ',0.25)';
		$css[]       = "#post-title::after{background:linear-gradient(240deg,$bg_color 50%,$light_color 100%)}";
		// $css[] = "#main::after{background:$light_color}";

		// ボタン
		$css[] = '[data-button="submit"],#submit,.primay-bg-color{background-color:' . $primary_color . '}';

		// 横幅とレイアウト
		$body_width = body_width_4536();
		$width      = str_replace( 'width-', '', $body_width );
		$body_width = '.' . $body_width . ' ';
		$css[]      = $body_width . '#header-image,' . $body_width . '.container,' . $body_width . '.inner{max-width:' . $width . 'px}';

		// タイトルの中央寄せ
		$is_slide_menu = is_slide_menu();
		$has_pc_nav    = has_nav_menu( 'header_nav' );
		if ( $is_slide_menu && ! $has_pc_nav ) {
			$css[] = '@media screen and (min-width: 768px){#sitename{text-align:center}}';
		} elseif ( ! $is_slide_menu && $has_pc_nav ) {
			$css[] = '@media screen and (max-width: 767px){#sitename{text-align:center}}';
		} elseif ( ! $is_slide_menu && ! $has_pc_nav ) {
			$css[] = '#sitename{text-align:center}';
		}

		// ヘッダー画像があれば
		if ( has_header_image() ) {
			$css[] = '#header-image img{display:block;margin:0 auto}';
		}

		// カエレバの背景画像
		if ( ( kaereba_convert() === 'amp' && is_amp() ) || kaereba_convert() === 'singular_amp' ) {
			$search         = '/<div class="(kaerebalink-image|booklink-image)".*?><a.+?><img.+?\/?><\/a><\/div>/i';
			$kaereba_search = preg_match_all( $search, $content, $match );
			if ( $kaereba_search || is_admin() ) {
				foreach ( $match[0] as $kaereba_image ) {
					$img   = null;
					$src   = null;
					$class = null;
					if ( preg_match( '/<img.+?src=["\']([^"\']+?)["\'].+?\/?>/i', $kaereba_image, $image ) ) {
						$src = $image[1];
					}
					$class = get_thumbnail_class_4536( $src );
					$css[] = '.' . $class . '{background-image:url("' . $src . '")}';
				}
			}
		}
		if ( kaereba_design() === 'amp' && is_amp() || kaereba_design() === 'singular_amp' ) {
			$css[] = '.booklink-box,.kaerebalink-box{width:100%;margin:0 0 2em;padding:1em 1em 0 1em !important;border:1px solid;border-color:#eaeaea #ddd #d0d0d0;border-radius:2px;font-size:small;overflow: hidden;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-flow:row wrap;flex-flow:row wrap}.booklink-box:after,.kaerebalink-box:after{content:"";display:block;visibility:hidden;height:0;clear:both}.booklink-image-4536,.kaerebalink-image-4536{width:30%;display:-webkit-box;display:-ms-flexbox;display:flex;margin:0 1em 1em 0 !important}.booklink-image-4536 a,.kaerebalink-image-4536 a{width:100%;display:-webkit-box;display:-ms-flexbox;display:flex}.booklink-image-thumbnail,.kaerebalink-image-thumbnail{width:100%;background-repeat:no-repeat;background-position:center;background-size:contain}.booklink-info,.kaerebalink-info{margin:0 0 1em 0 !important;-webkit-box-flex:1;-ms-flex:1;flex:1}.booklink-name,.kaerebalink-name{font-weight:700;margin-bottom:10px}.booklink-name p,.kaerebalink-name p{margin-bottom:10px;line-height:1.4}.booklink-name a:hover,.kaerebalink-name a:hover{text-decoration:underline}.booklink-powered-date,.kaerebalink-powered-date{font-size:10px;font-weight:400}.booklink-detail{font-size:10px;margin-bottom:10px}.booklink-link2,.kaerebalink-link1{margin-top:10px;width:100%;text-align:center}.booklink-link2 div,.kaerebalink-link1 div{display:block !important;margin:5px 0 !important;line-height:1.4}.booklink-link2 div a,.kaerebalink-link1 div a{display:block;padding:10px;color:#fff}.shoplinkamazon a{background:#f90}.shoplinkkindle a{background:#1882c9}.shoplinkrakuten a{background:#bf0000}.shoplinkrakukobo a{background:#ff2626}.shoplinkyahoo a{background:#fc1d2f}.shoplinkyahooAuc a{color:#252525 !important;background:#ffdb00}.shoplinkwowma a{background:#f02d1f}.shoplinkseven a{background:#225093}.shoplinkbellemaison a{background:#83be00}.shoplinkcecile a{background:#6b053d}.shoplinkkakakucom a{background:#00138e}.shoplinkbk1 a{background:#0484d2}.shoplinkehon a{background:#00006a}.shoplinkkino a{background:#003e9d}.shoplinkjun a{color:#4b5854 !important;background:#d8c9b7}.shoplinktoshokan a{background:#29b6e9}' .
			'@media screen and (min-width: 768px) {.booklink-link2 div,.kaerebalink-link1 div{float:left;width:49%}.booklink-link2 div:nth-child(odd),.kaerebalink-link1 div:nth-child(odd){margin-right:2%!important}}';
		}

		// Gutenberg
		if ( is_amp() ) {
			if ( preg_match_all( '/<div.+?class=".*?wp-block-cover.*?".*?>/i', $content, $matches ) ) {
				foreach ( $matches[0] as $cover_block ) {
					preg_match( '/style=".*?background-image:url\((.+?)\).*?"/i', $cover_block, $url );
					$url   = $url[1];
					$class = get_thumbnail_class_4536( $url );
					$css[] = '.' . $class . '{background-image:url("' . $url . '")}';
				}
			}
		}

		// メディアセクション
		if ( get_posts(
			[
				'post_type'      => 'music',
				'posts_per_page' => -1,
			]
		) ) {
			$css[] = '.music-content{width:200px;white-space:normal;vertical-align:top}.thumbnail-music-4536{padding-top:100%}.thumbnail-music-4536 img{border-radius:4px}';
		}
		if ( get_posts(
			[
				'post_type'      => 'movie',
				'posts_per_page' => -1,
			]
		) ) {
			$css[] = '.movie-content{width:196px;white-space:normal;vertical-align:top}.thumbnail-movie-4536{padding-top:56%}.thumbnail-movie-4536 img{border-radius:4px}';
		}

		// コピー禁止
		if ( copy_guard() ) {
			$css[] = 'body{-webkit-touch-callout:none;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}';
		}

		return $css;
	}
);
