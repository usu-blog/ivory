<?php

/**
 *
 */
class AdminMediaSetting_4536 {

  function __construct() {

    add_action( 'admin_menu', function() {
      add_submenu_page( '4536-setting', 'メディア', 'メディア', 'manage_options', 'media', [$this, 'form'] );
    });

    if ( isset( $_POST['admin_media_setting_submit_4536'] ) ) {
      $array = [
        'admin_main_media',
        'main_media_slug',
        'main_media_name',
        'admin_sub_media',
        'sub_media_slug',
        'sub_media_name',
      ];
      $main_slug = $_POST['main_media_slug'];
      $sub_slug = $_POST['sub_media_slug'];
      if( !ctype_lower( $main_slug ) || !ctype_lower( $sub_slug ) ) {
        add_action( 'admin_notices', function() {
          echo '<div class="error"><p>スラッグが無効な値のため保存できませんでした。半角英字で入力してください。</p></div>';
        });
        return;
      }
      foreach ( $array as $key ) {
        update_option_4536( $key );
      }
      flush_rewrite_rules( false );
      add_action( 'admin_notices', function() {
        echo '<div class="updated"><p>変更を保存しました。</p></div>';
      });
    }

  }


  function form() { ?>

    <div class="wrap">

        <h2>オリジナルメディア設定</h2>

        <p>※メディアについて</p>

        <p>4536ではアーティストのみなさんがすぐに自分の作品を発信できるように専用の投稿画面を用意しています。</p>

        <p>この専用の投稿画面から記事を公開することにより、通常の記事とは別の「目立つ場所」に記事の一覧が表示されます。</p>

        <p><i class="far fa-arrow-alt-circle-right"></i><a href="https://4536.jp/music-blog/" target="_blank">表示サンプル（デモ画面）はこちら</a></p>

        <p>初期状態では、ミュージック（音楽）、ムービー（動画）という名称ですが、それぞれ名称を変えることにより別ジャンルの作品を発信することも可能です。</p>

        <p><small>（例えば、「イラスト」という名称で自分が描いた絵を公開することも可能です）</small></p>

        <p><small>この機能を使わない場合はメディア名を空欄にしてください</small></p>

        <form method="post" action="">

            <?php settings_fields( 'media_group' ); do_settings_sections( 'media_group' ); ?>

            <!-- メインメディア -->
            <div class="metabox-holder">
            <div class="postbox">
                <h3 class="hndle">メインメディア</h3>
                <div class="inside">
                    <h4>管理画面に表示するメディア名</h4>
                    <input type="text" id="admin_main_media" name="admin_main_media" value="<?php echo get_option('admin_main_media'); ?>" />
                    <h4>スラッグ（半角アルファベットのみ）</h4>
                    <input type="text" id="main_media_slug" name="main_media_slug" pattern="^[0-9A-Za-z]+$" value="<?php echo get_option('main_media_slug'); ?>" />
                    <h4>サイトに表示する名称</h4>
                    <input type="text" id="main_media_name" name="main_media_name" value="<?php echo get_option('main_media_name'); ?>" />
                </div>
            </div>
            </div>

            <!-- サブメディア -->
            <div class="metabox-holder">
            <div class="postbox">
                <h3 class="hndle">サブメディア</h3>
                <div class="inside">
                    <h4>管理画面に表示するメディア名</h4>
                    <input type="text" id="admin_sub_media" name="admin_sub_media" value="<?php echo get_option('admin_sub_media'); ?>" />
                    <h4>スラッグ（半角アルファベットのみ）</h4>
                    <input type="text" id="sub_media_slug" name="sub_media_slug" pattern="^[0-9A-Za-z]+$" value="<?php echo get_option('sub_media_slug'); ?>" />
                    <h4>サイトに表示する名称</h4>
                    <input type="text" id="sub_media_name" name="sub_media_name" value="<?php echo get_option('sub_media_name'); ?>" />
                </div>
            </div>
            </div>

            <?php submit_button($text, 'primary large', 'admin_media_setting_submit_4536', $wrap, $other_attributes); ?>

        </form>

        <style>
          .far {
            margin-right: 5px;
          }
        </style>

    </div>

  <?php }

}
new AdminMediaSetting_4536();
