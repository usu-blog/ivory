<?php

class Custom_Field_4536 {

  public $title_arr = [
    'seo_title' => 'SEO用タイトル（タイトルタグ書き換え）',
    'sns_title' => 'SNS用タイトル',
  ];

  public $keyword_canonical_arr = [
    'keywords' => 'キーワード（コンマ区切り）',
    'canonical' => 'canonical（正規化するURL）',
  ];

  public $noindex_nofollow_arr = [
    'noindex' => 'NOINDEX（検索結果への表示をブロックします）',
    'nofollow' => 'NOFOLLOW（リンクを除外します）ほとんどの場合、チェックを入れる必要はありません。',
  ];

  public $add_html_js_css_arr = [
    'css_head' => 'headタグ内にこのページにだけ適用するCSSを追加できます。',
    'html_js_head' => 'headタグ内にこのページにだけ適用するHTML・JSコードを追加できます。',
    'html_js_body' => 'body閉じタグ前にこのページにだけ適用するHTML・JSコードを追加できます',
  ];

  function __construct() {
    add_filter( 'document_title_parts', [ $this, 'title_update' ] );
    add_action( 'add_meta_boxes', [ $this, 'init' ] );
    add_action( 'transition_post_status', [ $this, 'save' ], 10, 3 );
    add_action( 'wp_head_4536', [ $this, 'custom_seo_meta_4536' ] );
    add_action( 'admin_head-post.php', [ $this, 'text_counter' ] );
    add_action( 'admin_head-post-new.php', [ $this, 'text_counter' ] );
    add_action( 'admin_head-post.php', [ $this, 'style' ] );
    add_action( 'admin_head-post-new.php', [ $this, 'style' ] );
	}

  function init() {
    $list = [
      'SEO対策' => 'add_seo_form',
      '追加 HTML&JS&CSS' => 'add_html_js_css_form',
      'リダイレクト' => 'add_redirect_form',
    ];
    $args = [
      'public'   => true,
      '_builtin' => false
    ];
    $post_types = get_post_types( $args, 'names' );
    foreach( $list as $title => $id ) {
      add_meta_box( $id, $title, [$this, $id], 'post', 'side', 'low');
      add_meta_box( $id, $title, [$this, $id], 'page', 'side', 'low');
      foreach ( $post_types as $post_type ) {
        add_meta_box( $id, $title, [$this, $id], $post_type, 'side', 'low');
      }
    }
    $list = [
      'AMP' => 'amp_custom_fields',
      '目次' => 'toc_custom_fields',
      'アイキャッチ画像の出力' => 'none_post_thumbnail_custom_fields',
      '横幅の最大値' => 'singular_body_width_custom_fields',
      'レイアウト' => 'singular_layout_custom_fields',
    ];
    foreach( $list as $title => $id ) {
      add_meta_box( $id, $title, [$this, $id], 'post', 'side', 'default');
      add_meta_box( $id, $title, [$this, $id], 'page', 'side', 'default');
      foreach ( $post_types as $post_type ) {
        add_meta_box( $id, $title, [$this, $id], $post_type, 'side', 'default');
      }
    }
    add_meta_box( 'none_header_footer', '出力制御（LP向け）', [$this, 'none_header_footer'], 'page', 'side', 'default' );
  }

  function save( $new_status, $old_status, $post ) {
    if( ( $old_status == 'auto-draft'
    || $old_status == 'draft'
    || $old_status == 'pending'
    || $old_status == 'future')
    && $new_status == 'publish') {
      return $post;
    } else {
      add_action('save_post', function($post_id) {
        $arr = $this->title_arr;
        $arr += $this->keyword_canonical_arr;
        $arr += $this->noindex_nofollow_arr;
        $arr += $this->add_html_js_css_arr;
        $arr['amp'] = '';
        $arr['none_post_thumbnail'] = '';
        $arr['description'] = '';
        $arr['redirect'] = '';
        $arr['singular_layout_select'] = '';
        $arr['singular_body_width_select'] = '';
        $arr['toc'] = '';
        $arr['none_header_footer'] = '';
        foreach( $arr as $name => $val ) {
          if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
          if( isset($_POST['action']) && $_POST['action'] == 'inline-save' ) return $post_id;
          if( !empty($_POST[$name]) ) {
            update_post_meta( $post_id, $name, $_POST[$name] );
          } else {
            delete_post_meta( $post_id, $name );
          }
        }
      });
    }
  }

  function title_update($title) {
    global $post;
    $seo_title = get_post_meta($post->ID,'seo_title',true);
    if(is_singular() && $seo_title) $title['title'] = $seo_title;
    return $title;
  }

  ////////////////////////////////////
  // 設定項目の作成
  ////////////////////////////////////
  function add_seo_form() {
    global $post;
    foreach( $this->title_arr as $name => $description ) { ?>
      <label for="<?php echo $name; ?>" class="label-4536"><?php echo $description; ?></label>
      <input name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo esc_html(get_post_meta($post->ID, $name, true)); ?>" size="60" class="input-4536" type="text" />
      <p id="<?php echo $name; ?>-counter" class="counter"></p>
    <?php } ?>
    <label for="description" class="label-4536">ページの説明（推奨：160文字ほど）※何も入力しない場合、先頭の160文字が自動で使われます。</label>
    <textarea name="description" id="description" cols="60" rows="6" class="input-4536"><?php echo esc_html(get_post_meta($post->ID, 'description', true)); ?></textarea>
    <p id="description-counter" class="counter"></p>
    <?php foreach( $this->keyword_canonical_arr as $name => $description ) { ?>
      <p>
        <label for="<?php echo $name; ?>" class="label-4536"><?php echo $description; ?></label>
        <input name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo esc_html(get_post_meta($post->ID, $name, true)); ?>" size="60" class="input-4536" type="text" />
      </p>
    <?php }
    foreach( $this->noindex_nofollow_arr as $name => $description ) {
      $check = get_post_meta( $post->ID, $name ,true ) == 1 ? 'checked' : '/' ; ?>
      <p>
        <input type="checkbox" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="1" <?php echo $check; ?> >
        <label for="<?php echo $name; ?>" class="label-4536"><?php echo $description; ?></label>
      </p>
    <?php }
  }

  function add_html_js_css_form() {
    global $post;
    foreach( $this->add_html_js_css_arr as $name => $description ) { ?>
    <p>
      <label for="<?php echo $name; ?>" class="label-4536"><?php echo $description; ?></label>
      <textarea name="<?php echo $name; ?>" id="<?php echo $name; ?>" cols="60" rows="4" class="input-4536"><?php echo get_post_meta($post->ID, $name, true); ?></textarea>
    </p>
    <?php }
  }

  function amp_custom_fields() {
    global $post;
    $amp = get_post_meta( $post->ID, 'amp', true );
    $check = ( $amp == 1 ) ? 'checked' : '/' ;
    echo '<label class="select"><input type="checkbox" name="amp" id="amp" value="1" ' . $check . '>AMP機能を無効にする</label>';
  }

  function none_post_thumbnail_custom_fields() {
    global $post;
    $amp = get_post_meta( $post->ID, 'none_post_thumbnail', true );
    $check = ( $amp == 1 ) ? 'checked' : '/' ;
    echo '<label><input type="checkbox" name="none_post_thumbnail" id="none_post_thumbnail" value="1" ' . $check . '>アイキャッチ画像を表示しない</label>';
    echo '<p><small>※内部の構造化データにはアイキャッチ画像情報が記述されます。</small></p>';
  }

  function toc_custom_fields() {
    global $post;
    $toc = get_post_meta( $post->ID, 'toc', true );
    $check = ( $toc == 1 ) ? 'checked' : '/' ;
    echo '<label class="select"><input type="checkbox" name="toc" id="toc" value="1" ' . $check . '>目次を出力しない</label>';
  }

  function none_header_footer() {
    global $post;
    $none_header_footer = get_post_meta( $post->ID, 'none_header_footer', true );
    $check = ( $none_header_footer == 1 ) ? 'checked' : '/' ;
    echo '<label class="select"><input type="checkbox" name="none_header_footer" value="1" ' . $check . '>ヘッダーとフッターの出力を停止する</label>';
  }

  function add_redirect_form() {
    global $post;
    $redirect = get_post_meta( $post->ID, 'redirect', true );
    echo '<label for="redirect" class="label-4536">301リダイレクト先（URL）</label><input name="redirect" id="redirect" value="'.esc_url($redirect).'" size="60" class="input-4536" type="text" />';
  }

  function singular_layout_custom_fields() {
    global $post;
    $get_layout = get_post_meta( $post->ID, 'singular_layout_select', true );
    $layout_arr = [
      'left-content' => '2カラム（右サイドバー：デフォルト）',
      'right-content' => '2カラム（左サイドバー）',
      'center-content' => '1カラム（サイドバーなし）',
    ];
    ?>
    <p><small>ここで設定したレイアウトが優先して使われます。</small></p>
    <select id="singular-layout-select" name="singular_layout_select" type="text">
      <option value="">選択してください</option>
      <?php foreach( $layout_arr as $layout => $description ) {
        $selected = ( $layout === $get_layout ) ? ' selected' : '';
        echo '<option value="' . $layout . '"' . $selected . '>' . $description . '</option>';
      } ?>
    </select>
  <?php }

  function singular_body_width_custom_fields() {
    global $post;
    $get_body_width = get_post_meta( $post->ID, 'singular_body_width_select', true );
    $width_arr = [
      'width-780' => '780px',
      'width-880' => '880px',
      'width-980' => '980px',
      'width-1080' => '1080px',
      'width-1180' => '1180px',
      'width-1280' => '1280px',
      'width-1380' => '1380px',
      'width-1480' => '1480px',
    ];
    ?>
    <p><small>ここで設定した値が横幅の最大値になります。</small></p>
    <select id="singular-body-width-select" name="singular_body_width_select" type="text">
      <option value="">選択してください</option>
      <?php foreach( $width_arr as $width => $description ) {
        $selected = ( $width === $get_body_width ) ? ' selected' : '';
        echo '<option value="' . $width . '"' . $selected . '>' . $description . '</option>';
      } ?>
    </select>
  <?php }

  ////////////////////////////////////
  // 設定の反映
  ////////////////////////////////////
  function custom_seo_meta_4536() {
    global $post;
    $keywords = get_post_meta($post->ID,'keywords',true);
    $noindex = get_post_meta($post->ID,'noindex',true);
    $nofollow = get_post_meta($post->ID,'nofollow',true);
    $canonical = get_post_meta($post->ID,'canonical',true);
    $robots = null;
    if($noindex && $nofollow) $robots = '<meta name="robots" content="noindex,nofollow">';
    if($noindex && !$nofollow) $robots = '<meta name="robots" content="noindex,follow">';
    if(!$noindex && $nofollow) $robots = '<meta name="robots" content="nofollow">';
    $url = get_post_meta($post->ID, 'redirect', true);
    if($url) $robots = null;
    if(description_4536()) $description = '<meta name="description" content="'.description_4536().'">';
    if(is_home() && seo_setting_home()) { // トップページ
        if(top_keywords()) echo '<meta name="keywords" content="'.top_keywords().'">';
        echo $description;
    } elseif(seo_setting_post() && is_singular()) { //記事ページ
        echo $robots;
        if($keywords) echo '<meta name="keywords" content="'.$keywords.'">';
        echo $description;
    } elseif(seo_setting_archive() && is_archive()) {
        echo $description;
    }
    if( !is_amp() ) {
      if( !empty( $html_js_head = get_post_meta( $post->ID, 'html_js_head', true ) ) && is_singular() ) echo $html_js_head;
      if( !empty( $css_head = get_post_meta( $post->ID, 'css_head', true ) ) && is_singular() ) echo '<style>'. $css_head .'</style>';
    }
  }

  ////////////////////////////////////
  // 文字数カウンター
  ////////////////////////////////////
  function text_counter() { ?>
    <script type="text/javascript">
      var list = [
        '#seo_title',
        '#description',
        '#sns_title'
      ];
      $(function() {
        $.each(list, function(index,value) {
          function counter() {
            var length = $(value).val().length;
            $(value + '-counter').html(length);
          }
          counter();
          $(value).on('keydown keyup keypress change', counter);
        });
      });
    </script>
  <?php }

  function style() { ?>
    <style>
      .counter {
        text-align: right;
        width: 100%;
      }
      .title-counter-length-over {
        color: #f00;
        font-weight: bold;
      }
      input,textarea {
        max-width: 100%;
      }
      ul.children {
        padding-left: 1.5em;
      }
    </style>
  <?php }

}
new Custom_Field_4536();

add_action( 'wp_footer', function() {
  global $post;
  if( is_amp() ) return;
  if( $html_js_body = get_post_meta($post->ID, 'html_js_body', true) && is_singular() ) echo $html_js_body;
});

function none_header_footer() {
  if( !is_page() ) return;
  global $post;
  return !empty( $boolean = get_post_meta( $post->ID, 'none_header_footer', true ) ) ? $boolean : false;
}

function amp_exclude() {
  global $post;
  return !empty( $amp = get_post_meta( $post->ID, 'amp', true ) ) ? $amp : false;
}

add_action( 'get_header', function() {
  global $post;
  if( is_single() || is_page() ) {
    if( !empty( $url = get_post_meta( $post->ID, 'redirect', true ) ) ) {
      wp_redirect( $url , 301 );
      exit;
    }
  }
});
