<?php

/**
 *
 */
class AdminDatabaseSettings_4536 {

  public $aioseo_import_args = [
    'import_aioseo_title' => [
      'name' => 'タイトル',
      'meta_key' => 'seo_title',
      'aioseo_meta_key' => '_aioseop_title',
    ],
    'import_aioseo_description' => [
      'name' => 'ディスクリプション（記事の説明文）',
      'meta_key' => 'description',
      'aioseo_meta_key' => '_aioseop_description',
    ],
    'import_aioseo_keywords' => [
      'name' => 'キーワード',
      'meta_key' => 'keywords',
      'aioseo_meta_key' => '_aioseop_keywords',
    ],
    'import_aioseo_noindex' => [
      'name' => 'noindex',
      'meta_key' => 'noindex',
      'aioseo_meta_key' => '_aioseop_noindex',
    ],
    'import_aioseo_nofollow' => [
      'name' => 'nofollow',
      'meta_key' => 'nofollow',
      'aioseo_meta_key' => '_aioseop_nofollow',
    ],
  ];

  function __construct() {

    add_action( 'admin_init', function() {
      register_setting( 'database_group', 'embed_cache_delete' );
      foreach( $this->aioseo_import_args as $key => $value ) {
        register_setting( 'database_group', $key );
      }
    });

    add_action( 'admin_menu', function() {
      add_submenu_page( '4536-setting', 'データベース', 'データベース', 'manage_options', 'database', [$this, 'form'] );
    });

    if( isset($_POST['embed_cache_delete_submit_4536']) ) {
      update_option_4536( 'embed_cache_delete' );
      $this->cache_delete();
      add_action( 'admin_notices', function() {
        echo '<div class="updated"><p>キャッシュを削除しました。</p></div>';
      });
    }

    if( isset($_POST['aioseo_data_import_submit_4536']) ) {
      foreach ($this->aioseo_import_args as $key => $value) {
        update_option_4536( $key );
      }
      $this->data_import();
      add_action( 'admin_notices', function() {
        echo '<div class="updated"><p>インポートしました。</p></div>';
      });
    }

  }

  function cache_delete() {

    global $wpdb;

    $all_cache = $wpdb->prepare("
      DELETE FROM $wpdb->postmeta
      WHERE meta_key LIKE %s
    ", '_oembed_%' );

    $unknown_cache = $wpdb->prepare("
      DELETE FROM $wpdb->postmeta
      WHERE meta_key LIKE %s
      AND meta_value = %s
    ", '_oembed_%', '{{unknown}}' );

    $blogcard_cache = $wpdb->prepare("
      DELETE FROM $wpdb->options
      WHERE option_name LIKE %s
      OR option_value LIKE %s
    ", '_transient_blogcard_cache_4536_%', '_transient_timeout_blogcard_cache_4536_%' );

    $ogp_cache = $wpdb->prepare("
      DELETE FROM $wpdb->options
      WHERE option_name LIKE %s
      OR option_value LIKE %s
    ", '_transient_ogp_cache_4536_%', '_transient_timeout_ogp_cache_4536_%' );

    switch( get_option('embed_cache_delete') ) {
      case 'all':
        $wpdb->query( $all_cache );
        $wpdb->query( $blogcard_cache );
        $wpdb->query( $unknown_cache );
        $wpdb->query( $ogp_cache );
        break;
      case 'blogcard':
        $wpdb->query( $blogcard_cache );
        break;
      case 'ogp':
        $wpdb->query( $ogp_cache );
        break;
      case 'unknown':
        $wpdb->query( $unknown_cache );
        break;
    }

  }

  function data_import() {

    $list = $this->aioseo_import_args;

    foreach ($list as $key => $value) {

      // title,keyword,description
      $args = [
        'post_type' => 'any',
        'posts_per_page' => -1,
        'meta_key' => $value['aioseo_meta_key'],
        'meta_value' => null,
        'meta_compare' => '!=',
      ];
      $postslist = get_posts($args);
      if( !empty($postslist) && get_option($key)==='1' ) {
        foreach ($postslist as $post) {
          $meta_key = get_post_meta( $post->ID, $value['meta_key'], true );
          $meta_key_aioseo = get_post_meta( $post->ID, $value['aioseo_meta_key'], true );
          if(empty($meta_key)) {
            update_post_meta( $post->ID, $value['meta_key'], $meta_key_aioseo );
          }
        }
      }

      // noindex,nofollow
      $args = [
        'post_type' => 'any',
        'posts_per_page' => -1,
        'meta_key' => $value['aioseo_meta_key'],
        'meta_value' => 'on',
      ];
      $postslist = get_posts($args);
      if( !empty($postslist) && get_option($key)==='1' ) {
        foreach ($postslist as $post) {
          update_post_meta( $post->ID, $value['meta_key'], 1 );
        }
      }

    }

  }

  function form() { ?>

    <div class="wrap">

        <h2>データベース操作</h2>

        <p>
          <small style="color:red;">
            <i class="fas fa-exclamation-circle"></i>この画面で操作する前に必ずバックアップをとってください。バックアップが簡単にできるプラグインは<a href="plugin-install.php?s=UpdraftPlus&tab=search&type=term">UpdraftPlus</a>です
          </small>
        </p>

        <!-- <p><i class="far fa-arrow-alt-circle-right"></i><a href="https://4536.jp/speeding-up" target="_blank" >高速化について</a></p> -->

        <form method="post" action="">

        <?php settings_fields( 'database_group' ); do_settings_sections( 'database_group' ); ?>

        <!-- キャッシュ削除  -->
        <div class="metabox-holder">
        <div class="postbox" >
            <h3 class="hndle">埋め込みコンテンツのキャッシュ削除</h3>
            <div class="inside">
              <?php
              $cache_args = [
                'all' => 'すべての埋め込みコンテンツ',
                'blogcard' => '内部URLのブログカード',
                'ogp' => '外部URLのブログカード',
                'unknown' => '他のテーマなどでカスタムされたブログカード',
              ];
              foreach($cache_args as $val => $description) { ?>
                <p>
                    <input type="radio" name="embed_cache_delete" id="<?php echo $val.'_button'; ?>" value="<?php echo $val; ?>" <?php checked(get_option('embed_cache_delete'), $val);?> />
                    <label for="<?php echo $val.'_button'; ?>"><?php echo $description; ?></label>
                </p>
              <?php } ?>
              <p>
                <?php submit_button('キャッシュを削除する', 'primary large', 'embed_cache_delete_submit_4536', $wrap, $other_attributes); ?>
              </p>
            </div>
        </div>
        </div>

        <!-- All in One SEO Packのデータ引き継ぎ -->
        <div class="metabox-holder">
        <div class="postbox" >
            <h3 class="hndle">All in One SEO Packのデータインポート</h3>
            <div class="inside">

              <?php
              $function = new AdminDatabaseSettings_4536();
              $aioseo_import_args = $function->aioseo_import_args;
              foreach ($aioseo_import_args as $key => $value) { ?>
                <p>
                    <input type="checkbox" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="1" <?php checked( get_option($key), 1 ); ?> />
                    <label for="<?php echo $key; ?>"><?php echo $value['name']; ?></label>
                </p>
              <?php } ?>

              <p>
                <?php submit_button('データをインポートする', 'primary large', 'aioseo_data_import_submit_4536', $wrap, $other_attributes); ?>
              </p>

            </div>
        </div>
        </div>

        </form>

        <style>
            .far,.fas {
                margin-right: 5px;
            }
        </style>

    </div>

  <?php }

}
new AdminDatabaseSettings_4536();
