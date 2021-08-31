<?php

/**
 *
 */
class AdminSeoSetting_4536 {

  function __construct() {
    add_action( 'admin_menu', function() {
      add_submenu_page( '4536-setting', 'SEO', 'SEO', 'manage_options', 'seo', [$this, 'form'] );
    });
  }

  function form() { ?>
    <div class="wrap">
      <h2>SEO設定</h2>
      <p><small>SEOプラグインで管理する場合は入力する必要はありません。</small></p>
      <form method="post" action="options.php">
        <?php settings_fields( 'seo_group' ); do_settings_sections( 'seo_group' ); ?>
        <!-- GoogleAnalytics -->
        <div class="metabox-holder">
          <div class="postbox" >
            <h3 class="hndle">Googleアナリティクス設定</h3>
            <div class="inside">
              <h4 class="google_analytics_tracking_id">トラッキングID（UA-◯◯）</h4>
              <input type="text" id="google_analytics_tracking_id" name="google_analytics_tracking_id" value="<?php echo get_option('google_analytics_tracking_id'); ?>" />
              <!--プレビューで読み込み-->
              <p><label><input type="checkbox" name="google_analytics_preview_count" value="1" <?php checked(get_option('google_analytics_preview_count'), 1);?> />カスタマイズやプレビュー画面もカウント対象にする</label></p>
              <!--ログインユーザーのカウント-->
              <p><label><input type="checkbox" name="google_analytics_logged_in_user_count" value="1" <?php checked(get_option('google_analytics_logged_in_user_count'), 1);?> />管理画面にログインしているユーザーもカウント対象にする</label></p>
            </div>
          </div>
        </div>
        <!-- home seo -->
        <div class="metabox-holder">
          <div class="postbox" >
            <h3 class="hndle">トップページのSEO対策</h3>
            <div class="inside">
              <!--記事毎のSEO対策-->
              <p><label><input type="checkbox" name="admin_seo_home" value="1" <?php checked(get_option('admin_seo_home'), 1);?> />有効にする</label></p>
              <!--keyword-->
              <h4>メタキーワード</h4>
              <p><small>サイトのキーワードをカンマ区切り（例：〇〇,〇〇,〇〇）で入力してください。SEO効果はほぼないので空欄のままでもOK。サイトの見た目には影響しない項目です。</small></p>
              <input type="text" id="admin_home_keyword" name="admin_home_keyword" size="80" value="<?php echo get_option('admin_home_keyword'); ?>" />
              <!--description-->
              <h4>メタディスクリプション</h4>
              <p><small>入力しない場合は、一般→「キャッチフレーズ」で入力したテキストが使われます。</small></p>
              <textarea name="admin_home_description" rows="5" cols="80" id="admin_home_description"><?php echo get_option('admin_home_description'); ?></textarea>
            </div>
          </div>
        </div>
        <!--記事毎のSEO対策-->
        <div class="metabox-holder">
          <div class="postbox" >
            <h3 class="hndle">各種設定</h3>
            <div class="inside">
              <?php
              $list = [
                'admin_seo_post' => '記事毎のSEO対策を有効にする',
                'admin_seo_archive' => 'アーカイブページにディスクリプション（説明文）を生成する',
                'admin_ogp' => 'ソーシャルメディアのSEO対策を有効にする',
                'admin_canonical' => 'canonicalを追加する',
                'admin_next_prev' => 'next,prevを追加する',
              ];
              foreach($list as $name => $description) { ?>
                <p><label><input type="checkbox" name="<?php echo $name; ?>" value="1" <?php checked(get_option($name), 1);?> /><?php echo $description; ?></label></p>
              <?php } ?>
            </div>
          </div>
        </div>
        <!-- カテゴリーnoindex -->
        <div class="metabox-holder">
          <div class="postbox" >
            <h3 class="hndle">noindexにするカテゴリーページ</h3>
            <div class="inside">
              <p><small>※記事ページではなく「カテゴリーページ」のみをnoindexにします。</small></p>
              <ul style="height:auto;max-height:150px;overflow-y:scroll;margin:0;background-color:#fcfcfc;padding:.5em;display:inline-block;box-sizing:border-box;">
                <?php
                $walker = new Walker_Category_Checklist_Widget (
                  'noindex_category_archive'
                );
                wp_category_checklist( 0, 0, get_option( 'noindex_category_archive' ), false, $walker, false );
                ?>
              </ul>
            </div>
          </div>
        </div>
        <style>
          ul.children {
            padding: .5em 0 0 1em;
          }
        </style>
        <!-- noindexの記事 -->
        <div class="metabox-holder">
          <div class="postbox" >
            <h3 class="hndle">noindexしている記事ID一覧</h3>
            <div class="inside">
              <p style="word-break:break-all;">
                <?php
                $args = [
                  'post_type' => 'any',
                  'posts_per_page' => -1,
                  'meta_key' => 'noindex',
                  'meta_value' => 1,
                ];
                $postslist = get_posts($args);
                if( !empty( $postslist ) ) {
                  foreach ($postslist as $post) {
                    $noindex_posts .= $post->ID;
                    if( next( $postslist ) ) $noindex_posts .= ',';
                  }
                  echo '<textarea readonly onfocus="this.select();" rows="3" style="width:100%" id="noindex-posts" />' . $noindex_posts . '</textarea>';
                } else {
                  echo 'noindexしている記事はありません';
                }
                ?>
              </p>
              <p class="button" id="copy"><i class="far fa-copy"></i> コピーする</p>
              <script>
                function copy() {
                  const copyText = document.querySelector("#noindex-posts");
                  copyText.select();
                  document.execCommand("copy");
                }
                document.querySelector("#copy").addEventListener("click", copy);
              </script>
            </div>
          </div>
        </div>
        <?php submit_button( $text, 'primary large', 'admin_seo_setting_submit_4536', $wrap, $other_attributes ); ?>
      </form>
    </div>
  <?php }

}
new AdminSeoSetting_4536();
