<?php
/**
 *
 */
class EasySettings_4536 {

  public $design_theme = [
    '_default' => 'デフォルト（ブルー系）',
    'dark-black' => 'ダークブラック',
    'sea-green' => 'シーグリーン',
    'deep-pink' => 'ディープピンク',
    'minimal-red' => 'ミニマルレッド',
    'instagram' => '（ライク）インスタグラム',
    'sound-cloud' => 'サウンドクラウド',
  ];

  function __construct() {
    add_action( 'admin_init', function() {
      register_setting( 'design_theme_group', 'design_theme_4536' );
    });
    add_action( 'admin_menu', function() {
      add_submenu_page( '4536-setting', 'デザインテーマ', 'デザインテーマ', 'manage_options', 'design-theme', [$this, 'form'] );
    });
    if( isset( $_POST['design_theme_submit_4536'] ) ) {
      update_option_4536( 'design_theme_4536' );
      $name = get_option( 'design_theme_4536' );
      $path = TEMPLATEPATH . '/design-theme/' . $name . '.json';
      if( !file_exists($path) ) {
        add_action( 'admin_notices', function() {
          echo '<div class="error"><p>デザインテーマが見つかりませんでした。エラーを開発者に報告してください。</p></div>';
        });
        return;
      }
      ob_start();
      require_once( $path );
      $json = ob_get_clean();
      $array = json_decode( $json );
      foreach( $array as $key => $value ) {
        set_theme_mod( $key, $value );
      }
      $styles = [ 'h2', 'h3', 'h4' ];
      foreach( $styles as $style ) {
        remove_theme_mod( "{$style}_style" );
      }
      add_action( 'admin_notices', function() {
        echo '<div class="updated"><p>変更を保存しました。</p></div>';
      });
    }
  }
  function form() { ?>

    <div class="wrap">

      <h2>デザインテーマ</h2>

      <p><i class="fas fa-info-circle"></i><a href="https://4536.jp/design-theme" target="_blank" >デザインテーマについて</a></p>

      <form method="post" action="">

        <?php settings_fields( 'design_theme_group' ); do_settings_sections( 'design_theme_group' ); ?>

        <!-- デザインテーマ  -->
        <div class="metabox-holder">
          <div class="postbox" >
            <h3 class="hndle">デザインテーマ一覧</h3>
            <div class="inside">
              <?php
              foreach( $this->design_theme as $key => $value ) { ?>
                <p><label><input type="radio" name="design_theme_4536" value="<?php echo $key; ?>" <?php checked(get_option('design_theme_4536'), $key);?> /><?php echo $value; ?></label></p>
              <?php } ?>
              <p><?php submit_button( 'デザインテーマを変更する', 'primary large', 'design_theme_submit_4536', $wrap, $other_attributes ); ?></p>
            </div>
          </div>
        </div>

        <div id="column-2-section">
          <div class="metabox-holder column-2">
            <div class="postbox" >
              <h3 class="hndle">現在のサイトデザイン（トップページ）</h3>
              <div class="inside">
                <iframe sandbox src="<?php echo site_url(); ?>"></iframe>
              </div>
            </div>
          </div>
          <div class="metabox-holder column-2">
            <div class="postbox" >
              <h3 class="hndle">現在のサイトデザイン（投稿記事をランダムで表示）</h3>
              <div class="inside">
                <?php
                $myposts = get_posts([
                  'posts_per_page' => 1,
                  'orderby' => 'rand',
                  'post_type' => 'post',
                  'post_status' => 'publish',
                ]);
                foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
                  <iframe sandbox src="<?php the_permalink( $post->ID ); ?>"></iframe>
                <?php
                endforeach;
                wp_reset_postdata();
                ?>
              </div>
            </div>
          </div>
        </div>

        <p><small>※デザインテーマは随時追加していきます。ご要望などは<a href="https://4536.jp/forums" target="_blank">フォーラム</a>までどうぞ。</small></p>

      </form>

      <style>
        .far,.fas {
          margin-right: 5px;
        }
        .column-2 iframe {
          width:100%;
          height:300px;
        }
        @media screen and (min-width: 768px) {
          #column-2-section {
            display: flex;
          }
          .column-2 {
            flex:1;
          }
          .column-2 iframe {
            height: 500px;
          }
        }
      </style>

    </div>

  <?php }
}
new EasySettings_4536();
