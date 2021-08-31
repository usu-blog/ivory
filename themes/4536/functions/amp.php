<?php

// 参考：https://nelog.jp/wordpress-content-to-amp
// 参考：https://wp-simplicity.com/

function is_amp()
{
    $boolean = false;
    if (empty($_GET['amp'])) {
        return $boolean;
    }
    $arr = [
    'post' => 'single',
    'page' => 'page',
    'music' => 'media',
    'movie' => 'media',
  ];
    foreach ($arr as $post_type => $d) {
        if (is_singular($post_type) && is_amp_post_type($d) && $_GET['amp']==='1') {
            $boolean = true;
        }
    }
    if (is_page_template('page-templates/search-page.php')) {
        $boolean = false;
    }
    return $boolean;
}

//AMP用にコンテンツを変換する
function convert_content_to_amp($the_content)
{
    if (!is_amp()) {
        return $the_content;
    }

    //C2A0文字コード（UTF-8の半角スペース）を通常の半角スペースに置換
    $the_content = str_replace('\xc2\xa0', ' ', $the_content);

    //style属性を取り除く
    $the_content = preg_replace('/ +style=["][^"]*?["]/i', '', $the_content);
    $the_content = preg_replace('/ +style=[\'][^\']*?[\']/i', '', $the_content);

    //target属性を取り除く
    $the_content = preg_replace('/ +target=["][^"]*?["]/i', '', $the_content);
    $the_content = preg_replace('/ +target=[\'][^\']*?[\']/i', '', $the_content);

    //onclick属性を取り除く
    $the_content = preg_replace('/ +onclick=["][^"]*?["]/i', '', $the_content);
    $the_content = preg_replace('/ +onclick=[\'][^\']*?[\']/i', '', $the_content);

    //FONTタグを取り除く
    $the_content = preg_replace('/<font[^>]+?>/i', '', $the_content);
    $the_content = preg_replace('/<\/font>/i', '', $the_content);

    //marginwidth属性を取り除く
    $the_content = preg_replace('/ +?marginwidth=["][^"]*?["]/i', '', $the_content);
    $the_content = preg_replace('/ +?marginwidth=[\'][^\']*?[\']/i', '', $the_content);
    //marginheight属性を取り除く
    $the_content = preg_replace('/ +?marginheight=["][^"]*?["]/i', '', $the_content);
    $the_content = preg_replace('/ +?marginheight=[\'][^\']*?[\']/i', '', $the_content);
    //contenteditable属性を取り除く
    $the_content = preg_replace('/ +?contenteditable=["][^"]*?["]/i', '', $the_content);
    $the_content = preg_replace('/ +?contenteditable=[\'][^\']*?[\']/i', '', $the_content);
    //sandbox属性を取り除く
    $the_content = preg_replace('/ +?sandbox=["][^"]*?["]/i', '', $the_content);
    $the_content = preg_replace('/ +?sandbox=[\'][^\']*?[\']/i', '', $the_content);
    //security属性を取り除く
    $the_content = preg_replace('/ +?security=["][^"]*?["]/i', '', $the_content);
    $the_content = preg_replace('/ +?security=[\'][^\']*?[\']/i', '', $the_content);

    //カエレバ・ヨメレバのAmazon商品画像にwidthとhightを追加する
    $the_content = preg_replace('/ src="http:\/\/ecx.images-amazon.com/i', ' width="75" height="75" sizes="(max-width: 75px) 75vw, 75px" src="http://ecx.images-amazon.com', $the_content);
    //カエレバ・ヨメレバのAmazon商品画像にwidthとhightを追加する（SSL用）
    $the_content = preg_replace('/ src="https:\/\/images-fe.ssl-images-amazon.com/i', ' width="75" height="75" sizes="(max-width: 75px) 75vw, 75px" src="https://images-fe.ssl-images-amazon.com', $the_content);
    //カエレバ・ヨメレバの楽天商品画像にwidthとhightを追加する
    $the_content = preg_replace('/ src="http:\/\/thumbnail.image.rakuten.co.jp/i', ' width="75" height="75" sizes="(max-width: 75px) 75vw, 75px" src="http://thumbnail.image.rakuten.co.jp', $the_content);
    //カエレバ・ヨメレバの楽天商品画像にwidthとhightを追加する（SSL用）
    $the_content = preg_replace('/ src="https:\/\/thumbnail.image.rakuten.co.jp/i', ' width="75" height="75" sizes="(max-width: 75px) 75vw, 75px" src="https://thumbnail.image.rakuten.co.jp', $the_content);
    //カエレバ・ヨメレバのYahoo!ショッピング商品画像にwidthとhightを追加する
    $the_content = preg_replace('/ src="http:\/\/item.shopping.c.yimg.jp/i', ' width="75" height="75" sizes="(max-width: 75px) 75vw, 75px" src="http://item.shopping.c.yimg.jp', $the_content);
    //カエレバ・ヨメレバのYahoo!ショッピング商品画像にwidthとhightを追加する（SSL用）
    $the_content = preg_replace('/ src="https:\/\/item.shopping.c.yimg.jp/i', ' width="75" height="75" sizes="(max-width: 75px) 75vw, 75px" src="https://item.shopping.c.yimg.jp', $the_content);

    //アプリーチの画像対応
    $the_content = preg_replace('/<img([^>]+?src="[^"]+?(mzstatic\.com|phobos\.apple\.com|googleusercontent\.com|ggpht\.com)[^"]+?[^>\/]+)\/?>/is', '<amp-img$1 width="75" height="75" sizes="(max-width: 75px) 100vw, 75px"></amp-img>', $the_content);
    $the_content = preg_replace('/<img([^>]+?src="[^"]+?nabettu\.github\.io[^"]+?[^>\/]+)\/?>/is', '<amp-img$1 width="135" height="40" sizes="(max-width: 135px) 100vw, 135px"></amp-img>', $the_content);

    //画像変換
    $img_pattern = preg_match_all('/<img(.+?)\/?>/is', $the_content, $images);
    if ($img_pattern) {
        foreach ($images[0] as $image) {
            $src = null;
            $width = null;
            $height = null;
            $alt = null;
            $title = null;
            $sizes = null;
            if (preg_match('/src=["\']([^"\']+?)["\']/i', $image, $src)) {
                $url = $src[1];
                $src = $src[0].' ';
                $data = get_image_width_and_height_4536($url);
            }
            if (preg_match('/width=["\']([^"\']*?)["\']/i', $image, $widths)) {
                $width = $widths[0].' ';
                $sizes = 'sizes="(max-width: '.$widths[1].'px) 100vw, '.$widths[1].'px"';
            } else {
                $w_px = ($data) ? $data['width'] : '100';
                $width = 'width="'.$w_px.'" ';
                $sizes = 'sizes="(max-width: '.$w_px.'px) 100vw, '.$w_px.'px"';
            }
            if (preg_match('/height=["\']([^"\']*?)["\']/i', $image, $height)) {
                $height = $height[0].' ';
            } else {
                $h_px = ($data) ? $data['height'] : '100';
                $height = 'height="'.$h_px.'" ';
            }
            $alt = (preg_match('/alt=["]([^"]*?)["]/i', $image, $alt)) ? $alt[0].' ' : 'alt ';
            $amp_img = '<amp-img '.$src.$width.$height.$alt.$sizes.'></amp-img>';
            $the_content = preg_replace('{'.preg_quote($image).'}', $amp_img, $the_content);
        }
    }

    //変換漏れの画像をAMP用に置換
    $the_content = preg_replace('/<img(.+?)\/?>/is', '<amp-img$1></amp-img>', $the_content);

    // Twitterをamp-twitterに置換する（埋め込みコード）
    $pattern = '/<blockquote class="twitter-tweet".*?>.+?<a href="https:\/\/twitter.com\/.*?\/status\/(.*?)">.+?<\/blockquote>/is';
    $append = '<p><amp-twitter width=592 height=472 layout="responsive" data-tweetid="$1"></amp-twitter></p>';
    if (preg_match($pattern, $the_content, $matches) === 1) {
        $the_content = preg_replace($pattern, $append, $the_content);
    }

    // Instagramをamp-instagramに置換する
    $pattern = '/<blockquote class="instagram-media".+?"https:\/\/www.instagram.com\/p\/(.+?)\/.*?".+?<\/blockquote>/is';
    $append = '<p><amp-instagram layout="responsive" data-shortcode="$1" width="592" height="592" ></amp-instagram></p>';
    if (preg_match($pattern, $the_content, $matches) === 1) {
        $the_content = preg_replace($pattern, $append, $the_content);
    }

    // YouTubeを置換する（埋め込みコード）
    $pattern = '/<iframe.+?src="https:\/\/www.youtube.com\/embed\/(.+?)(\?rel=0)(\?feature=oembed)?".*?><\/iframe>/is';
    $append = '<amp-youtube layout="responsive" data-videoid="$1" width="800" height="450"></amp-youtube>';
    if (preg_match($pattern, $the_content, $matches) === 1) {
        $the_content = preg_replace($pattern, $append, $the_content);
    }

    // vineをamp-vineに置換する
    $pattern = '/<iframe[^>]+?src="https:\/\/vine.co\/v\/(.+?)\/embed\/simple".+?><\/iframe>/is';
    $append = '<p><amp-vine data-vineid="$1" width="592" height="592" layout="responsive"></amp-vine></p>';
    if (preg_match($pattern, $the_content, $matches) === 1) {
        $the_content = preg_replace($pattern, $append, $the_content);
    }

    // SoundCloud
    $pattern = '/<iframe.+?src="https:\/\/w.soundcloud.com\/player\/\?url=https%3A\/\/api.soundcloud.com\/(tracks|playlists)\/(\d+)&.*?height="(\d+)".*?><\/iframe>/is';
    $append = '<amp-soundcloud data-$1id="$2" height="$3" layout="fixed-height" data-visual="true"></amp-soundcloud>';
    if (preg_match($pattern, $the_content, $matches) === 1) {
        $the_content = preg_replace($pattern, $append, $the_content);
    }
    $the_content = str_replace('<amp-soundcloud data-tracksid', '<amp-soundcloud data-trackid', $the_content);
    $the_content = str_replace('<amp-soundcloud data-playlistsid', '<amp-soundcloud data-playlistid', $the_content);

    //amazon baner link
    $pattern = '/<iframe.+?src="((https:)?\/\/rcm-fe\.amazon-adsystem\.com.+?)".+?(width="\d+")?.(height="\d+")?.*?>/is';
    if (preg_match_all($pattern, $the_content, $amazon_links)) {
        $i = 0;
        foreach ($amazon_links[0] as $link) {
          $src = '';
          $scheme = '';
          $width = '';
          $height = '';
            $src = $amazon_links[1][$i];
            $scheme = $amazon_links[2][$i];
            if( empty($scheme) ) $src = 'https:' . $src;
            $width = $amazon_links[3][$i];
            $height = $amazon_links[4][$i];
            if( !$src ) continue;
            if( !$width || !$height ) {
              $width = 'width="120"';
              $height = 'height="240"';
            }
            $src = ' src="' . $src . '"';
            $width = ' ' . $width;
            $height = ' ' . $height;
            $new_link = '<amp-iframe sandbox="allow-scripts allow-same-origin allow-popups"' . $src . $width . $height . '>';
            $the_content = str_replace($link, $new_link, $the_content);
            $i++;
        }
    }

    // iframeをamp-iframeに置換する
    $pattern = '/<iframe/i';
    $append = '<amp-iframe layout="responsive" sandbox="allow-scripts allow-same-origin allow-popups"';
    if (preg_match($pattern, $the_content, $matches) === 1) {
        $the_content = preg_replace($pattern, $append, $the_content);
    }
    $pattern = '/<\/iframe>/i';
    $append = '<span placeholder></span></amp-iframe>';
    if (preg_match($pattern, $the_content, $matches) === 1) {
        $the_content = preg_replace($pattern, $append, $the_content);
    }

    // videoをamp-videoに置換する
    $pattern = '/<video/i';
    $append = '<amp-video layout="responsive"';
    if (preg_match($pattern, $the_content, $matches) === 1) {
        $the_content = preg_replace($pattern, $append, $the_content);
    }
    $pattern = '/<\/video>/i';
    $append = '</amp-video>';
    if (preg_match($pattern, $the_content, $matches) === 1) {
        $the_content = preg_replace($pattern, $append, $the_content);
    }

    //スクリプトをpタグごと除去する
    $pattern = '/<p><script.+?<\/script><\/p>/is';
    $append = '';
    if (preg_match($pattern, $the_content, $matches) === 1) {
        $the_content = preg_replace($pattern, $append, $the_content);
    }

    //スクリプトが残っていれば除去する
    $pattern = '/<script.+?<\/script>/is';
    $append = '';
    if (preg_match($pattern, $the_content, $matches) === 1) {
        $the_content = preg_replace($pattern, $append, $the_content);
    }

    //目次修正
    $pattern = '/<span id="AMP">/i';
    $append = '<span id="AMP-1">';
    if (preg_match($pattern, $the_content, $matches) === 1) {
        $the_content = preg_replace($pattern, $append, $the_content);
    }
    $pattern = '/<a href="#AMP">/i';
    $append = '<a href="#AMP-1">';
    if (preg_match($pattern, $the_content, $matches) === 1) {
        $the_content = preg_replace($pattern, $append, $the_content);
    }

    return $the_content;
}
add_filter('the_content', 'convert_content_to_amp', 99999);
add_filter('widget_text', 'convert_content_to_amp', 99999);
add_filter('widget_item_new', 'convert_content_to_amp', 99999);
add_filter('post_thumbnail_html', function ($image) {
    preg_match('/class="(.+?)"/i', $image, $class);
    if (empty($class)) {
        return $image;
    }
    if (strpos($class[1], 'blogcard-thumb-image') !== false) {
        return $image;
    }
    return convert_content_to_amp($image);
}, 999);

//////////////////////////////
//AMP用アドセンス広告生成
//////////////////////////////
function amp_adsense_code($locate)
{
    $ad = get_amp_adsense_code();
    preg_match('/data-ad-client="(ca-pub-[^"]+?)"/i', $ad, $match);
    if (empty($match[1])) {
        return;
    }
    $data_ad_client = $match[1];
    preg_match('/data-ad-slot="([^"]+?)"/i', $ad, $match);
    if (empty($match[1])) {
        return;
    }
    $data_ad_slot = $match[1];

    //size
    switch ($locate) {
    case 'before_h2':
    case 'post_bottom':
    case 'sidebar':
      $layout = '';
      $width = ' width="100vw"';
      $height = '320';
      $option = ' data-auto-format="rspv" data-full-width';
      $overflow = '<div overflow></div>';
      break;
    case 'header':
    case 'post_top':
      $layout = ' layout="fixed-height"';
      $width = '';
      $height = '100';
      $option = '';
      $overflow = '';
      break;
    default:
      return;
      break;
  }

    switch ($locate) {
    case 'header':
      $container_class = 'mt-5 mb-5 pa-3 container mx-auto';
      break;
    case 'post_top':
      $container_class = 'mb-4';
      break;
    case 'before_h2':
      $container_class = 'mt-5 mb-5';
      break;
    case 'post_bottom':
      $container_class = 'mt-5';
      break;
    case 'sidebar':
      $container_class = 'mb-5';
      break;
  }

    //title
    $ad_title = (!empty(amp_ad_title())) ? '<div class="meta mb-2 post-color" data-text-align="center">' . amp_ad_title() . '</div>' : '';

    //for mobile phone
    $amp_adsense_code = '<amp-ad media="(max-width: 479px)" height="' . $height . '" type="adsense" data-ad-client="' . $data_ad_client . '" data-ad-slot="' . $data_ad_slot . '"'. $layout . $width . $option . '>' . $overflow . '</amp-ad>';

    if ($locate === 'sidebar') { //only sidebar
        //for tablet and pc
        $amp_adsense_code .= '<amp-ad media="(min-width: 480px)" width=300 height=250 type="adsense" data-ad-client="' . $data_ad_client . '" data-ad-slot="' . $data_ad_slot . '"></amp-ad>';
    } else {
        //for tablet and pc
        $amp_adsense_code .= '<amp-ad media="(min-width: 480px)" layout="fixed-height" height=200 type="adsense" data-ad-client="' . $data_ad_client . '" data-ad-slot="' . $data_ad_slot . '"></amp-ad>';
    }

    $amp_adsense = '<div class="w-100 amp-adsense ' . $container_class . '">' . $ad_title . $amp_adsense_code . '</div>';

    if (
    (get_option('amp_adsense_post')==='' && is_singular('post')) ||
    (get_option('amp_adsense_page')==='' && is_page()) ||
    (get_option('amp_adsense_media')==='' && is_singular([ 'music', 'movie' ]))
  ) {
        return;
    }
    return $amp_adsense;
}

//アバター画像変換
add_filter('get_avatar', function ($avatar) {
    if (!is_amp()) {
        return $avatar;
    }

    //style属性を取り除く
    $avatar = preg_replace('/ +style=["][^"]*?["]/i', '', $avatar);
    $avatar = preg_replace('/ +style=[\'][^\']*?[\']/i', '', $avatar);
    $avatar = str_replace('<img', '<amp-img', $avatar);
    $avatar = '<div>'.$avatar.'</div>';
    return $avatar;
}, 9999999999);
