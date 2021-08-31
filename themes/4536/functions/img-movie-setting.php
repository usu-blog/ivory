<?php

//レスポンシブiframe
add_filter('the_content', function ($the_content) {
    if (is_singular()) {
        $the_content = preg_replace('/<iframe[^>]+?youtube\.com[^<]+?<\/iframe>/i', '<div class="responsive-wrapper">${0}</div>', $the_content);
    }
    return $the_content;
});

//アイキャッチ画像を有効にする
add_theme_support('post-thumbnails');

//サムネイルの自動生成
add_filter('admin_init', function () {
    add_settings_field('thumbnail_generate_4536', 'サムネイルの自動生成', 'thumbnail_generate_4536', 'media');
    register_setting('media', 'thumbnail_generate_4536');
});
function thumbnail_generate_4536() { ?>
    <p>
        <input type="checkbox" id="thumbnail_generate_4536" name="thumbnail_generate_4536" value="1" <?php checked(get_option('thumbnail_generate_4536'), 1);?> />
        <label for="thumbnail_generate_4536">テーマ側で設定したサイズのサムネイルを自動生成する</label>
    </p>
<?php }
if (get_option('thumbnail_generate_4536')===false) {
    update_option('thumbnail_generate_4536', 1);
}
if (get_option('thumbnail_generate_4536')) { //サムネイルを生成
    if (esc_html(get_option('admin_main_media')) ||
       thumbnail_size()=='thumbnail') {
        add_image_size('thumb100_100', 100, 100, true);
        add_image_size('thumb150_150', 150, 150, true);
        add_image_size('thumb300_300', 300, 300, true);
        add_image_size('thumb500_500', 500, 500, true);
    }
    if (esc_html(get_option('admin_sub_media'))) {
        add_image_size('thumb196_110', 196, 110, true);
        add_image_size('thumb400_231', 400, 231, true);
    }
    if (thumbnail_size()=='thumbnail-wide') {
        add_image_size('thumb100_75', 100, 75, true);
        add_image_size('thumb150_113', 150, 113, true);
        add_image_size('thumb300_225', 300, 225, true);
        add_image_size('thumb500_375', 500, 375, true);
    }
}

function get_some_image_4536($content)
{
    $w_px = get_image_width_and_height_4536(get_some_image_url_4536($content))['width'];
    $h_px = get_image_width_and_height_4536(get_some_image_url_4536($content))['height'];
    $sizes = ' sizes="(max-width:'.$w_px.'px) 100vw, '.$w_px.'px"';
    $thumbnail = '<img src="'.get_some_image_url_4536($content).'" alt="'.get_the_title().'" width="'.$w_px.'" height="'.$h_px.'"'.$sizes.'>';
    return $thumbnail;
}

function get_some_image_url_4536($content = null)
{
    $src = get_first_image_4536($content);
    if (empty($src) && has_site_icon()) {
        $src = get_site_icon_url();
    }
    if (empty($src)) {
        $src = no_image_url_4536();
    }
    return $src;
}

function no_image_url_4536()
{
    $height = (thumbnail_size()==='thumbnail') ? '512' : '341' ;
    $src = get_template_directory_uri().'/img/no-image-512-'.$height.'.png';
    return $src;
}

//アイキャッチ画像情報取得
function get_the_post_thumbnail_4536()
{
    $src = get_the_post_thumbnail_url();
    $path_parts = pathinfo($src);
    $filename = $path_parts['filename'];
    preg_match('/-\d+x\d+$/i', $filename, $m);
    if ($m) {
        $filename = str_replace($m[0], '', $filename);
        $src = $path_parts['dirname'].'/'.$filename.'.'.$path_parts['extension'];
    }
    $class = get_thumbnail_class_4536($src);
    return [
        'thumbnail' => $thumbnail,
        'src' => $src,
        'class' => $class
    ];
}

//アイキャッチ画像出力
function the_post_thumbnail_4536()
{
    if (!has_post_thumbnail()) {
        return;
    }
    $primary_color = primary_color();
    $secandary_color = secandary_color();
    ?>
    <div class="xs12 sm12 md6 pr-3 pl-3 mt-5 mb-4" data-position="relative">
      <svg class="post-thumbnail-shape" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 920.4 769.85">
        <defs>
          <linearGradient id="post-thumbnail-gradation" class="drop-shadow-shape" x1="25.96" y1="394.65" x2="969.22" y2="394.65" gradientUnits="userSpaceOnUse">
            <stop offset="0" stop-color="<?php echo $primary_color; ?>" />
            <stop offset="1" stop-color="<?php echo $secandary_color; ?>"/>
          </linearGradient>
        </defs>
        <path d="M877.56,66c37,31.17,52.48,68.48,58,82,62.47,153.17-35.19,395.75-213,527-124.7,92-251.58,100.68-279,102-59.95,2.89-234.22,10.84-340-122-76.74-96.37-86.75-224.57-56-320C69.11,268.1,109.34,221,125,204c17.51-19.05,54.14-54.72,109-81,81.15-38.87,112.08-14,225-35C593.61,62.93,596.14,18.89,705,17,744.34,16.32,818.26,16.07,877.56,66Z" transform="translate(-31.35 -16.86)" fill="url(#post-thumbnail-gradation)" fill-opacity="0.25" />
        <path d="M856.51,81a213,213,0,0,1,55.08,77.72c59.32,145.18-33.41,375.1-202.26,499.5-118.41,87.24-238.9,95.43-264.94,96.68C387.47,757.6,222,765.14,121.53,639.23,22.47,515.05,62.8,356.41,68.35,335.93c16.78-61.86,52.39-100.24,73.12-124.17C257.78,77.48,425.72,53.52,534,38.07,647.56,21.87,771,4.26,856.51,81Z" transform="translate(-34.08 -8.35)" fill="url(#post-thumbnail-gradation)" fill-opacity="0.1" />
      </svg>
      <div id="post-thumbnail-4536" class="t-0 b-0 r-0 l-0 pa-3" data-position="absolute" data-display="flex" data-justify-content="center" data-align-items="center">
        <figure class="post-thumbnail w-100 h-100" data-position="relative">
          <?php the_post_thumbnail( 'full', ['class' => 'post-top-thumbnail'] ); ?>
        </figure>
      </div>
    </div>
<?php }

/////////////////////////////
//カエレバ画像変換
/////////////////////////////
add_filter('the_content', function ($the_content) {
    if (kaereba_convert()=='amp' && !is_amp()) {
        return $the_content;
    }
    $search = '/<div class="(kaerebalink-image|booklink-image)".*?><a.+?><img.+?\/?><\/a><\/div>/i';
    if (preg_match_all($search, $the_content, $match)) {
        foreach ($match[0] as $kaereba_image) {
            $s = null;
            $link = null;
            $src = null;
            $e_link = null;
            $e = null;
            $class = null;
            if (preg_match('/<div.+?class="(kaerebalink-image|booklink-image)".*?>/i', $kaereba_image, $start)) {
                $s = '<div class="'.$start[1].'-4536">';
            }
            if (preg_match('/<a.+?>/i', $kaereba_image, $link)) {
                $link = $link[0];
            }
            if (preg_match('/<img.+?src=["\']([^"\']+?)["\'].+?\/?>/i', $kaereba_image, $image)) {
                $src = $image[1];
            }
            if (preg_match('/<\/a>/i', $kaereba_image, $e_link)) {
                $e_link = $e_link[0];
            }
            if (preg_match('/<\/div>/i', $kaereba_image, $e)) {
                $e = $e[0];
            }
            $class = get_thumbnail_class_4536($src);
            $new_kaereba_image = $s.$link.'<div class="'.$class.' '.$start[1].'-thumbnail"></div>'.$e_link.$e;
            $the_content = preg_replace('{'.preg_quote($kaereba_image).'}', $new_kaereba_image, $the_content);
        }
    }
    return $the_content;
});

//////////////////////////////
//Gutenbergのカバー画像
//////////////////////////////
add_filter('the_content', function ($the_content) {
    if (preg_match_all('/<div.+?class=".*?wp-block-cover.*?".*?>/i', $the_content, $matches)) {
        foreach ($matches[0] as $cover_block) {
            preg_match('/style=".*?background-image:url\((.+?)\).*?"/i', $cover_block, $url);
            $class = get_thumbnail_class_4536($url[1]);
            $new_cover_block = str_replace('class="', 'class="'.$class.' ', $cover_block);
            $the_content = preg_replace('{'.preg_quote($cover_block).'}', $new_cover_block, $the_content);
        }
    }
    return $the_content;
});

//画像URLから幅と高さを取得する（同サーバー内ファイルURLのみ）
function get_image_width_and_height_4536($image_url)
{
    $res = null;
    $wp_content_dir = WP_CONTENT_DIR;
    $wp_content_url = content_url();
    if (strpos($image_url, $wp_content_url) === false) {
        return $res;
    }
    $image_file = str_replace($wp_content_url, $wp_content_dir, $image_url);
    $imagesize = getimagesize($image_file);
    if ($imagesize) {
        $res = [];
        $res['width'] = $imagesize[0];
        $res['height'] = $imagesize[1];
        return $res;
    }
}

//画像URLからクラスを生成
function get_thumbnail_class_4536($src)
{
    setlocale(LC_ALL, 'ja_JP.UTF-8');
    $path_parts = pathinfo($src);
    $dirname = $path_parts['dirname'];
    if (preg_match('{'.preg_quote(site_url()).'}', $dirname)) {
        $dirname = str_replace(wp_upload_dir(), '', $dirname);
    } else {
        $dirname = '';
    }
    $basename = $path_parts['basename'];
    $class = $dirname.$basename;
    $class = preg_replace('/\W/', '', $class);
    $class = 't-'.$class;
    return esc_html($class);
}

/////////////////////////////
//コピー禁止
/////////////////////////////
add_filter('wp_footer', function () {
    if (!copy_guard()) {
        return;
    } ?>
    <script>
        $(function() {
            $('img').on('contextmenu oncopy', function() {
                return false;
            });
            $('img').on('dragstart', function (e) {
                e.stopPropagation();
                e.preventDefault();
            });
        });
    </script>
<?php
}, 999999);


//ヘッダーロゴ
function header_logo_4536()
{
    if (is_amp()) {
        $start_tag = '<amp-img srcset="'.header_logo_url().' 238w" ';
        $end_tag = '></amp-img>';
    } else {
        $start_tag = '<img ';
        $end_tag = '>';
    }
    $alt = 'alt="'.get_bloginfo('name').'" ';
    $width = 'width="238" ';
    $height = 'height="48" ';
    $class = 'class="header-logo" ';
    $url = 'src="'.header_logo_url().'" ';
    $header_logo = $start_tag.$url.$alt.$class.$width.$height.$end_tag;
    return $header_logo;
}

//前後の記事のサムネ
function prev_next_post_thumbnail($post_id)
{
    if (!has_post_thumbnail($post_id)) {
        echo '<div class="post-thumbnail prev-post-thumbnail w-100 h-100"></div>';
        return;
    }

    echo '<figure class="post-thumbnail prev-post-thumbnail w-100 h-100">'.get_the_post_thumbnail($post_id).'</figure>';
}

/////////////////////////////////////////////
//コピペ一発でWordpressの投稿時にアイキャッチを自動設定するカスタマイズ方法（YouTube対応版）
//http://nelog.jp/auto-post-thumbnail-custum
/////////////////////////////////////////////

//WP_Filesystemの利用
require_once(ABSPATH . '/wp-admin/includes/image.php');

//イメージファイルがサーバー内にない場合は取得する
function fetch_thumbnail_image_4536($matches, $key, $post_content, $post_id)
{
    //サーバーのphp.iniのallow_url_fopenがOnでないとき外部サーバーから取得しない
    if (!ini_get('allow_url_fopen')) {
        return null;
    }
    //正しいタイトルをイメージに割り当てる。IMGタグから抽出
    $imageTitle = '';
    preg_match_all('/<\s*img [^\>]*title\s*=\s*[\""\']?([^\""\'>]*)/i', $post_content, $matchesTitle);

    if (count($matchesTitle) && isset($matchesTitle[1])) {
        if (isset($matchesTitle[1][$key])) {
            $imageTitle = $matchesTitle[1][$key];
        }
    }

    //処理のためのURL取得
    $imageUrl = $matches[1][$key];

    //ファイル名の取得
    $filename = substr($imageUrl, (strrpos($imageUrl, '/'))+1);

    if (!(($uploads = wp_upload_dir(current_time('mysql'))) && false === $uploads['error'])) {
        return null;
    }

    //ユニック（一意）ファイル名を生成
    $filename = wp_unique_filename($uploads['path'], $filename);

    //ファイルをアップロードディレクトリに移動
    $new_file = $uploads['path'] . "/$filename";

    if (!ini_get('allow_url_fopen')) {
        return null;
    //$file_data = curl_get_file_contents($imageUrl);
    } else {
        if (WP_Filesystem()) {//WP_Filesystemの初期化
      global $wp_filesystem;//$wp_filesystemオブジェクトの呼び出し
      //$wp_filesystemオブジェクトのメソッドとしてファイルを取得する
      $file_data = @$wp_filesystem->get_contents($imageUrl);
        }
    }

    if (!$file_data) {
        return null;
    }

    if (WP_Filesystem()) {//WP_Filesystemの初期化
    global $wp_filesystem;//$wp_filesystemオブジェクトの呼び出し
    //$wp_filesystemオブジェクトのメソッドとしてファイルに書き込む
    $wp_filesystem->put_contents($new_file, $file_data);
    }

    //ファイルのパーミッションを正しく設定
    $stat = stat(dirname($new_file));
    $perms = $stat['mode'] & 0000666;
    @ chmod($new_file, $perms);

    //ファイルタイプの取得。サムネイルにそれを利用
    $mimes = null;
    $wp_filetype = wp_check_filetype($filename, $mimes);

    extract($wp_filetype);

    //ファイルタイプがない場合、これ以上進めない
    if ((!$type || !$ext) && !current_user_can('unfiltered_upload')) {
        return null;
    }

    //URLを作成
    $url = $uploads['url'] . "/$filename";

    //添付（attachment）配列を構成
    $attachment = array(
    'post_mime_type' => $type,
    'guid' => $url,
    'post_parent' => null,
    'post_title' => $imageTitle,
    'post_content' => '',
  );

    $file = false;
    $thumb_id = wp_insert_attachment($attachment, $file, $post_id);
    if (!is_wp_error($thumb_id)) {
        //attachmentのアップデート
        wp_update_attachment_metadata($thumb_id, wp_generate_attachment_metadata($thumb_id, $new_file));
        update_attached_file($thumb_id, $new_file);

        return $thumb_id;
    }

    return null;
}

//投稿内の最初の画像をアイキャッチに設定する（Auto Post Thumnailプラグイン的な機能）
function auto_post_thumbnail_image_4536()
{
    global $wpdb;
    global $post;
    //$postが空の場合は終了
    if (isset($post) && isset($post->ID)) {
        $post_id = $post->ID;

        //アイキャッチが既に設定されているかチェック
        if (get_post_meta($post_id, '_thumbnail_id', true) || get_post_meta($post_id, 'skip_post_thumb', true)) {
            return;
        }

        $post = $wpdb->get_results("SELECT * FROM {$wpdb->posts} WHERE id = $post_id");

        //正規表現にマッチしたイメージのリストを格納する変数の初期化
        $matches = array();

        //投稿本文からすべての画像を取得
        preg_match_all('/<\s*img [^\>]*src\s*=\s*[\""\']?([^\""\'>]*).+?\/?>/i', $post[0]->post_content, $matches);
        //var_dump($matches);
        //YouTubeのサムネイルを取得（画像がなかった場合）
        if (empty($matches[0])) {
            preg_match('%(?:youtube\.com/(?:user/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $post[0]->post_content, $match);
            if (!empty($match[1])) {
                $matches=array();
                $matches[0]=$matches[1]=array('http://img.youtube.com/vi/'.$match[1].'/maxresdefault.jpg');
            }
        }

        if (count($matches)) {
            foreach ($matches[0] as $key => $image) {
                $thumb_id = null;
                //画像がイメージギャラリーにあったなら、サムネイルIDをCSSクラスに追加（イメージタグからIDを探す）
                preg_match('/wp-image-([\d]*)/i', $image, $thumb_id);
                if (isset($thumb_id[1])) {
                    $thumb_id = $thumb_id[1];
                }

                //サムネイルが見つからなかったら、データベースから探す
                if (!$thumb_id &&
           //画像のパスにサイト名が含まれているとき
           (strpos($image, site_url()) !== false)) {
                    //$image = substr($image, strpos($image, '"')+1);
                    preg_match('/src *= *"([^"]+)/i', $image, $m);
                    $image = $m[1];
                    if (isset($m[1])) {
                        //wp_postsテーブルからguidがファイルパスのものを検索してIDを取得
                        $result = $wpdb->get_results("SELECT ID FROM {$wpdb->posts} WHERE guid = '".$image."'");
                        //IDをサムネイルをIDにセットする
                        if (isset($result[0])) {
                            $thumb_id = $result[0]->ID;
                        }
                    }

                    //サムネイルなどで存在しないときはフルサイズのものをセットする
                    if (!$thumb_id) {
                        //ファイルパスの分割
                        $path_parts = pathinfo($image);
                        //サムネイルの追加文字列(-680x400など)を取得
                        preg_match('/-\d+x\d+$/i', $path_parts["filename"], $m);
                        //画像のアドレスにサイト名が入っていてサムネイル文字列が入っているとき
                        if (isset($m[0])) {
                            //サムネイルの追加文字列(-680x400など)をファイル名から削除
                            $new_filename = str_replace($m[0], '', $path_parts["filename"]);
                            //新しいファイル名を利用してファイルパスを結語
                            $new_filepath = $path_parts["dirname"].'/'.$new_filename.'.'.$path_parts["extension"];
                            //wp_postsテーブルからguidがファイルパスのものを検索してIDを取得
                            $result = $wpdb->get_results("SELECT ID FROM {$wpdb->posts} WHERE guid = '".$new_filepath."'");
                            //IDをサムネイルをIDにセットする
                            if (isset($result[0])) {
                                $thumb_id = $result[0]->ID;
                            }
                        }
                    }
                }


                //それでもサムネイルIDが見つからなかったら、画像をURLから取得する
                if (!$thumb_id) {
                    $thumb_id = fetch_thumbnail_image_4536($matches, $key, $post[0]->post_content, $post_id);
                }

                //サムネイルの取得に成功したらPost Metaをアップデート
                if ($thumb_id) {
                    update_post_meta($post_id, '_thumbnail_id', $thumb_id);
                    break;
                }
            }
        }
    }
}
if (get_post_first_image()==='get_save') {
    add_action('save_post', 'auto_post_thumbnail_image_4536');
    add_action('draft_to_publish', 'auto_post_thumbnail_image_4536');
    add_action('new_to_publish', 'auto_post_thumbnail_image_4536');
    add_action('pending_to_publish', 'auto_post_thumbnail_image_4536');
    add_action('future_to_publish', 'auto_post_thumbnail_image_4536');
    add_action('xmlrpc_publish_post', 'auto_post_thumbnail_image_4536');
}

//記事の最初の画像を取得（アイキャッチ画像として保存はしない）
function get_first_image_4536($content)
{
    if (get_post_first_image() !=='get') {
        return null;
    }
    preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $first_img);
    return (!empty($first_img)) ? $first_img[1] : '';
}

//オリジナルのサムネをセット
function save_original_thumbnail_4536($post_id)
{
    $image_url = attachment_url_to_postid(original_thumbnail_url());
    $post_thumbnail = get_post_meta($post_id, $key = '_thumbnail_id', $single = true);
    if (!wp_is_post_revision($post_id)) {
        if (empty($post_thumbnail)) {
            update_post_meta($post_id, $meta_key = '_thumbnail_id', $meta_value = $image_url);
        }
    }
}
if (get_post_first_image()=='original') {
    add_action('save_post', 'save_original_thumbnail_4536');
}
