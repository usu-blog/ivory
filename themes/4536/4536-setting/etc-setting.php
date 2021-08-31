<?php

/**
 *
 */
class AdminEtcSetting_4536 {

  function __construct() {

    add_action( 'admin_menu', function() {
      add_submenu_page( '4536-setting', 'その他', 'その他', 'manage_options', 'etc', [$this, 'form'] );
    });

  }

  function form() { ?>

    <div class="wrap">

        <h2>その他の設定</h2>

        <form method="post" action="options.php">

        <?php settings_fields( 'etc_group' ); do_settings_sections( 'etc_group' ); ?>

        <!-- 投稿の編集画面カスタマイズ -->
        <div class="metabox-holder">
        <div class="postbox" >
            <h3 class="hndle">「投稿の編集」エディアメニューの設定</h3>
            <div class="inside">
                <p><small>エディターメニュー2段目にボタンを追加</small></p>
                <!-- 検索置き換え -->
                <?php
                $list = [
                    'mce_button_searchreplace' => '検索置き換え',
                    'mce_button_source_code' => 'ソースコード編集',
                    'mce_button_balloon_left' => '左からの吹き出し',
                    'mce_button_balloon_right' => '右からの吹き出し',
                    'mce_button_balloon_think_left' => '左からの考え事風の吹き出し',
                    'mce_button_balloon_think_right' => '右からの考え事風の吹き出し',
                    'mce_button_point' => 'ワンポイント',
                    'mce_button_caution' => '注意書き',
                ];
                foreach($list as $name => $desc) { ?>
                <p>
                    <input type="checkbox" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="1" <?php checked(get_option($name), 1);?> />
                    <label for="<?php echo $name; ?>"><?php echo $desc; ?></label>
                </p>
                <?php } ?>
            </div>
        </div>
        </div>

        <!-- 子テーマのスタイルシート -->
        <?php if(is_child_theme()) { ?>
        <div class="metabox-holder">
        <div class="postbox" >
            <h3 class="hndle">子テーマのスタイルシート</h3>
            <div class="inside">
                <p>
                    <input type="checkbox" id="is_enable_child_stylesheet" name="is_enable_child_stylesheet" value="1" <?php checked(get_option('is_enable_child_stylesheet'), 1);?> />
                    <label for="is_enable_child_stylesheet">子テーマのスタイルシートを読み込む</label>
                </p>
            </div>
        </div>
        </div>
        <?php } ?>

        <!-- jQueryの読み込み -->
        <div class="metabox-holder">
        <div class="postbox" >
            <h3 class="hndle">jQueryライブラリの読み込み</h3>
            <div class="inside">
                <p>
                    <input type="checkbox" id="is_enable_jquery_lib" name="is_enable_jquery_lib" value="1" <?php checked(get_option('is_enable_jquery_lib'), 1);?> />
                    <label for="is_enable_jquery_lib">ライブラリを読み込む</label>
                </p>
            </div>
        </div>
        </div>

        <!-- エディター -->
        <div class="metabox-holder">
        <div class="postbox" >
            <h3 class="hndle">投稿画面の編集画面読み込み時の初期エディター</h3>
            <div class="inside">
                <p><small>WordPress5.0以前の標準エディター（TinyMCE）に関する設定です。</small></p>
                <p>
                    <input type="checkbox" id="first_tinymce_active_editor" name="first_tinymce_active_editor" value="1" <?php checked(get_option('first_tinymce_active_editor'), 1);?> />
                    <label for="first_tinymce_active_editor">最初のエディターを必ずビジュアルエディターにする</label>
                </p>
            </div>
        </div>
        </div>

        <!-- 追加HTML,JS-->
        <div class="metabox-holder">
        <div class="postbox" >
            <h3 class="hndle">追加HTML/JS</h3>
            <div class="inside">
                <p><small>独自のHTMLコード・JavaScriptコードを追加します。</small></p>
                <!-- headタグ内 -->
                <h4>headタグ内</h4>
                <textarea name="admin_add_html_js_head" rows="5" cols="80" id="admin_add_html_js_head"><?php echo get_option('admin_add_html_js_head'); ?></textarea>
                <!-- body閉じタグ前 -->
                <h4>body閉じタグ前</h4>
                <textarea name="admin_add_html_js_body" rows="5" cols="80" id="admin_add_html_js_body"><?php echo get_option('admin_add_html_js_body'); ?></textarea>
            </div>
        </div>
        </div>

        <!-- 自動バッググラウンド更新 -->
        <div class="metabox-holder">
        <div class="postbox" >
            <h3 class="hndle">自動バックグラウンド更新</h3>
            <div class="inside">
                <?php
                $list = [
                    'admin_wordpress_major_update' => 'メジャーアップデートを自動で行う',
                    'admin_wordpress_minor_update' => 'マイナーアップデートを自動で行う',
                    'admin_wordpress_dev_update' => '開発版アップデートを自動で行う',
                    'admin_wordpress_plugin_update_setting' => 'プラグインアップデートを自動で行う',
                    'admin_wordpress_theme_update' => 'テーマアップデートを自動で行う',
                    'wordpress_translation_update' => '翻訳アップデートを自動で行う',
                ];
                foreach($list as $name => $desc) { ?>
                <p>
                    <input type="checkbox" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="1" <?php checked(get_option($name), 1);?> />
                    <label for="<?php echo $name; ?>"><?php echo $desc; ?></label>
                </p>
                <?php } ?>
            </div>
        </div>
        </div>

        <!-- 絵文字無効 -->
        <div class="metabox-holder">
        <div class="postbox" >
            <h3 class="hndle">絵文字</h3>
            <div class="inside">
                <!-- メジャー -->
                <p>
                    <input type="checkbox" id="disenable_wp_emoji" name="disenable_wp_emoji" value="1" <?php checked(get_option('disenable_wp_emoji'), 1);?> />
                    <label for="disenable_wp_emoji">絵文字機能を無効にする</label>
                </p>
            </div>
        </div>
        </div>

        <?php submit_button(); ?>

        </form>

    </div>

  <?php }

}
new AdminEtcSetting_4536();
