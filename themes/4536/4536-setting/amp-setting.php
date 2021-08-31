<?php

/**
 *
 */
class AdminAmpSetting_4536 {

  public $is_amp_post_type = [
    'admin_amp' => '記事ページ',
    'is_amp_page' => '固定ページ',
    'is_amp_media' => 'メディアページ',
  ];
  public $amp_adsense_location = [
    'admin_amp_adsense_header' => 'ヘッダー',
    'admin_amp_adsense_post_top' => '記事上',
    'admin_amp_adsense_h2' => '記事中（h2見出し前）',
    'admin_amp_adsense_post_bottom' => '記事下広告枠',
    'admin_amp_adsense_sidebar' => 'モバイル表示時のサイドバー上部',
  ];
  public $is_amp_adsense_post_type = [
    'amp_adsense_post' => '記事ページ',
    'amp_adsense_page' => '固定ページ',
    'amp_adsense_media' => 'メディアページ',
  ];
  public $amp_html_custom = [
    'admin_amp_add_html_js_head' => 'headタグ内',
    'admin_amp_add_html_js_body' => 'body開始タグ直後',
  ];

  function __construct() {

    add_action( 'init', function() {
      foreach( $this->is_amp_adsense_post_type as $key ) {
        if( get_option($key) === false ) update_option( $key, 1 );
      }
    });

    add_action( 'admin_init', function() {
      $array_master = [];
      $array_master += $this->is_amp_post_type;
      $array_master += $this->amp_adsense_location;
      $array_master += $this->is_amp_adsense_post_type;
      $array_master += $this->amp_html_custom;
      $array_master['admin_amp_adsense_code'] = '';
      $array_master['admin_amp_adsense_title'] = '';
      foreach( $array_master as $key => $value ) {
        register_setting( 'amp_group', $key );
      }
    });

    add_action( 'admin_menu', function() {
      add_submenu_page( '4536-setting', 'AMP', 'AMP', 'manage_options', 'amp', [$this, 'form'] );
    });

  }

  function form() { ?>

    <div class="wrap">

      <h2>AMP設定</h2>

      <p><i class="far fa-arrow-alt-circle-right"></i><a href="https://4536.jp/amp" target="_blank">AMPとは？</a></p>

      <p><small>プラグインで対応する場合はこの画面で設定する必要はありません。</small></p>

      <form method="post" action="options.php">

        <?php settings_fields( 'amp_group' ); do_settings_sections( 'amp_group' ); ?>

        <!-- AMP有効 -->
        <div class="metabox-holder">
        <div class="postbox" >
          <h3 class="hndle">AMP対応するページの種類</h3>
          <div class="inside">
            <p><small>AMPページを生成します。記事毎にこの機能をオフにすることも可能です。</small></p>
            <?php foreach( $this->is_amp_post_type as $key => $value ) { ?>
              <p><label><input type="checkbox" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="1" <?php checked( get_option($key), 1 );?>><?php echo $value; ?></label></p>
            <?php } ?>
          </div>
        </div>
        </div>

        <!-- home seo -->
        <div class="metabox-holder">
        <div class="postbox" >
          <h3 class="hndle">Googleアドセンスの設定</h3>
          <div class="inside">
            <p><small>個別に管理する場合はウィジェットで設定してください。</small></p>
            <!--コード-->
            <h4>アドセンスのコード</h4>
            <p><small>「通常のアドセンスコード」を貼り付けてください。AMP用に自動変換されます。</small></p>
            <textarea name="admin_amp_adsense_code" rows="5" cols="80" id="admin_amp_adsense_code"><?php echo get_option('admin_amp_adsense_code'); ?></textarea>
            <!--タイトル-->
            <h4>アドセンス広告の上に表示するテキスト</h4>
            <p><small>タイトルを表示しない場合は空欄のままにしてください。</small></p>
            <input type="text" id="admin_amp_adsense_title" name="admin_amp_adsense_title" size="80" value="<?php echo get_option('admin_amp_adsense_title'); ?>" />
            <!--アドセンスの一括設定-->
            <h4>アドセンスを表示する部分</h4>
            <?php foreach( $this->amp_adsense_location as $key => $value ) { ?>
              <p><label><input type="checkbox" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="1" <?php checked( get_option($key), 1 );?>><?php echo $value; ?></label></p>
            <?php } ?>
            <!-- アドセンス表示ページ -->
            <h4>アドセンスを表示するページの種類</h4>
            <?php foreach( $this->is_amp_adsense_post_type as $key => $value ) { ?>
              <p><label><input type="checkbox" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="1" <?php checked( get_option($key), 1 );?>><?php echo $value; ?></label></p>
            <?php } ?>
          </div>
        </div>
        </div>

        <!-- 各種設定 -->
        <div class="metabox-holder">
        <div class="postbox" >
          <h3 class="hndle">コードの追加</h3>
          <div class="inside">
            <p><small>AMPページ用のHTMLコード・JavaScriptコードを追加することができます。</small></p>
            <?php foreach( $this->amp_html_custom as $key => $value ) { ?>
              <h4><?php echo $value; ?></h4>
              <textarea name="<?php echo $key; ?>" rows="5" cols="80" id="<?php echo $key; ?>"><?php echo get_option($key); ?></textarea>
            <?php } ?>
          </div>
        </div>
        </div>

        <?php submit_button(); ?>

        </form>

        <style>
          .far {
            margin-right: 5px;
          }
        </style>

    </div>

  <?php }

}
new AdminAmpSetting_4536();
