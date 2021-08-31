<?php

add_action('customize_register', function( $wp_customize ) {

	/*	テーマカスタマイザーにテキストエリア追加
	/*-------------------------------------------*/
	if( class_exists('WP_Customize_Control') ):
		class Textarea_Control extends WP_Customize_Control {
			public $type = 'textarea';
			public function render_content() { ?>
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<textarea rows="13" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
				</label>
			<?php }
		}
	endif;

	//既存のセクションに追加
	//ロゴ画像
  $wp_customize->add_setting( 'header_logo_url' );
  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_logo_url', [
    'section' => 'header_image',
    'settings' => 'header_logo_url',
    'label' => 'ロゴ画像',
    'description' => '（横幅238px・高さ48px）',
  ]));

//ページ設定
$wp_customize->add_section( 'page_setting', [
    'title' => 'ページ設定',
    'priority' => 30,
]);
    //Googleフォント
    $wp_customize->add_setting( 'add_google_fonts', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'add_google_fonts', [
        'section' => 'page_setting',
        'settings' => 'add_google_fonts',
        'label' => 'Googleフォント追加',
        'description' =>'<a href="https://fonts.google.com/" target="_blank" >Googleフォントの公式サイト</a>を参考にフォント名だけ入力すると、自分の好きなフォントを使用することができます。パラメーター（:800など）を付けると動作しませんので外してください。',
        'type' => 'text',
    ]);
    //Googleフォントの適用箇所
    $wp_customize->add_setting( 'is_google_fonts', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'is_google_fonts', [
        'section' => 'page_setting',
        'settings' => 'is_google_fonts',
        'label' =>'Googleフォントの適用箇所',
        'type' => 'select',
        'choices' => [
            null => '選択してください',
            'body' => 'すべてのフォントに適用',
            '#sitename a' => 'サイトのタイトル',
            'h2,h3,h4,h5' => '見出し',
        ],
    ]);
    //同じカテゴリ内でリンク
    $wp_customize->add_setting( 'next_prev_in_same_term', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'next_prev_in_same_term', [
        'section' => 'page_setting',
        'settings' => 'next_prev_in_same_term',
        'label' =>'前後記事のリンク',
        'type' => 'radio',
        'choices'    => [
            null => 'すべての記事（デフォルト）',
            'true' => '同じカテゴリだけ',
        ],
    ]);
    //この記事を書いた人
    $list = [
        'single' => '記事ページ',
        'page' => '固定ページ',
        'media' => 'メディアページ'
    ];
    foreach($list as $post_type => $label) {
        $wp_customize->add_setting( 'profile_'.$post_type, [
            'default' => true,
        ]);
        $wp_customize->add_control( 'profile_'.$post_type, [
            'section' => 'page_setting',
            'settings' => 'profile_'.$post_type,
            'label' => '記事下プロフィールの表示（'.$label.'）',
            'type' => 'checkbox',
        ]);
    }
    //前後の記事
    $wp_customize->add_setting( 'post_prev_next', [
        'default' => true,
    ]);
    $wp_customize->add_control( 'post_prev_next', [
        'section' => 'page_setting',
        'settings' => 'post_prev_next',
        'label' => '前後の記事を表示する',
        'type' => 'checkbox',
    ]);

//見出し
$wp_customize->add_section( 'heading_style', [
  'title' => '見出し',
  'priority' => 30,
  'description' => '見出しのデザインを変更できます。',
]);
    //見出しスタイル
    $h_style_list = [
      null => '装飾なし',
      'simple_bg_color' => '単色背景',
      'gradation_bg_color' => 'グラデーション背景',
      'simple_border_bottom' => '単色下線',
      'gradation_border_bottom' => 'グラデーション下線1',
      'gradation_border_bottom2' => 'グラデーション下線2',
      'simple_border_left' => '単色左線',
      'pop' => 'ポップ',
      'cool' => 'クール1',
      'cool2' => 'クール2',
      'cool3' => 'クール3',
    ];
    //見出しリスト
    $menu_list = [
        'gradation_bg_color' => '2',
        'gradation_border_bottom' => '3',
        'simple_border_left' => '4'
    ];
    foreach ($menu_list as $default => $number) {
        $wp_customize->add_setting( 'h'.$number.'_style', [
            'default' => $default,
        ]);
        $wp_customize->add_control( 'h'.$number.'_style', [
            'section' => 'heading_style',
            'settings' => 'h'.$number.'_style',
            'label' =>'記事内見出し'.$number,
            'priority' => $number.'0',
            'type' => 'select',
            'choices' => $h_style_list,
        ]);
    }

//検索
$wp_customize->add_section( 'search', [
    'title' => '検索機能',
    'priority' => 30,
]);
    //デフォルト検索 or Googleカスタム検索
    $wp_customize->add_setting( 'search_style', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'search_style', [
        'section' => 'search',
        'settings' => 'search_style',
        'label' =>'検索機能切り替え',
        'description' => 'WordPress標準の検索機能か、Googleカスタム検索かを選択できます。',
        'type' => 'radio',
        'choices' => [
            null => 'WordPress標準の検索',
            'google_custom_search' => 'Googleカスタム検索',
        ],
    ]);
    //Googleカスタム検索のコード
    $wp_customize->add_setting( 'google_custom_search_result', [
        'default' => null,
    ]);
    $wp_customize->add_control( new Textarea_Control( $wp_customize, 'google_custom_search_result', [
        'section' => 'search',
        'settings' => 'google_custom_search_result',
        'label' =>'検索結果コードを貼り付けてください。',
    ]));
    //Googleカスタム検索のスラッグ
    $wp_customize->add_setting( 'google_custom_search_slug', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'google_custom_search_slug', [
        'section' => 'search',
        'settings' => 'google_custom_search_slug',
        'label' =>'Googleカスタム検索の結果を表示するページのスラッグを入力してください。',
        'type' => 'text',
    ]);

//SNS関連
$wp_customize->add_section( 'SNS', [
    'title' => 'SNS',
    'priority' => 30,
]);
    //Twitterカード
    $wp_customize->add_setting( 'twitter_card', array (
        'default' => 'summary',
    ));
    $wp_customize->add_control( 'twitter_card', array(
        'section' => 'SNS',
        'settings' => 'twitter_card',
        'label' => 'Twitterカードの形',
        'type' => 'radio',
        'choices'    => [
            'summary' => '小さいカード（正方形の画像）',
            'summary_large_image' => '大きいカード（横長の大きい画像）',
        ],
        'priority' => 10,
    ));
    //Twitterのvia
    $wp_customize->add_setting( 'twitter_via', array (
        'default' => true,
    ));
    $wp_customize->add_control( 'twitter_via', array(
        'section' => 'SNS',
        'settings' => 'twitter_via',
        'label' =>'Twitterのviaを表示する',
        'description' => '記事がTweetされた時の「@〇〇」を表示します。',
        'type' => 'checkbox',
        'priority' => 20,
    ));

//コメント欄
$wp_customize->add_section( 'comments', [
    'title' => 'コメント設定',
]);
    //コメント欄の表示
    $list = [
        'single' => true,
        'page' => false,
        'media' => true,
    ];
    foreach($list as $post_type => $default) {
        $wp_customize->add_setting( 'is_comments_'.$post_type, [
            'default' => $default,
        ]);
    }
    $list = [
        'single' => '記事ページ',
        'page' => '固定ページ',
        'media' => 'メディアページ',
    ];
    foreach($list as $post_type => $label) {
        $wp_customize->add_control( 'is_comments_'.$post_type, [
            'section' => 'comments',
            'settings' => 'is_comments_'.$post_type,
            'label' =>'コメント欄を表示する（'.$label.'）',
            'type' => 'checkbox',
        ]);
    }
    //メールアドレス表示
    $wp_customize->add_setting( 'comments_email', array (
        'default' => true,
    ));
    $wp_customize->add_control( 'comments_email', array(
        'section' => 'comments',
        'settings' => 'comments_email',
        'label' =>'メールアドレス入力欄の表示',
        'type' => 'checkbox',
    ));
    //ウェブサイト削除
    $wp_customize->add_setting( 'comments_website', array (
        'default' => true,
    ));
    $wp_customize->add_control( 'comments_website', array(
        'section' => 'comments',
        'settings' => 'comments_website',
        'label' =>'ウェブサイト入力欄の表示',
        'type' => 'checkbox',
    ));
    //Cookie削除
    $wp_customize->add_setting( 'comments_cookies', array (
        'default' => true,
    ));
    $wp_customize->add_control( 'comments_cookies', array(
        'section' => 'comments',
        'settings' => 'comments_cookies',
        'label' =>'「次回のコメントで使用するため〜」の表示',
        'type' => 'checkbox',
    ));
    //「メールアドレスが公開されることはありません」を削除
    $wp_customize->add_setting( 'comments_mail_address_text', array (
        'default' => true,
    ));
    $wp_customize->add_control( 'comments_mail_address_text', array(
        'section' => 'comments',
        'settings' => 'comments_mail_address_text',
        'label' =>'「メールアドレスが公開されることはありません」の表示',
        'type' => 'checkbox',
    ));

//目次
$wp_customize->add_section( 'table_of_contents', [
    'title' => '目次',
]);
    //読み込み方選択
    $wp_customize->add_setting( 'is_toc', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'is_toc', [
        'section' => 'table_of_contents',
        'settings' => 'is_toc',
        'label' => '目次を表示するページ',
        'description' => '見出し2の手前に表示します。別の場所に表示する場合はウィジェットの目次をお使いください',
        'type' => 'radio',
        'choices'    => [
            null => '読み込まない（デフォルト）',
            'single' => '記事ページのみ',
            'page' => '固定ページのみ',
            'single_page' => '記事ページと固定ページ',
            'singular' => '目次が生成できるすべてのページ',
        ],
    ]);
    //読み込み方選択
    $wp_customize->add_setting( 'toc_headline_level', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'toc_headline_level', [
        'section' => 'table_of_contents',
        'settings' => 'toc_headline_level',
        'label' => '対象の見出し',
        'type' => 'radio',
        'choices'    => [
            null => '見出し2まで',
            'h3' => '見出し3まで',
            'h4' => '見出し4まで',
            'h5' => '見出し5まで',
        ],
    ]);
    //何個以上で表示するか
    $wp_customize->add_setting( 'toc_headline_count', [
        'default' => 3,
    ]);
    $wp_customize->add_control( 'toc_headline_count', [
        'section' => 'table_of_contents',
        'settings' => 'toc_headline_count',
        'label' => 'いくつ見出しがあれば表示するか',
        'type' => 'select',
        'choices'    => [
            1 => '1つ以上',
            2 => '2つ以上',
            3 => '3つ以上',
            4 => '4つ以上',
            5 => '5つ以上',
            6 => '6つ以上',
        ],
    ]);
    //何個以上で表示するか
    $wp_customize->add_setting( 'toc_title', [
        'default' => '目次',
    ]);
    $wp_customize->add_control( 'toc_title', [
        'section' => 'table_of_contents',
        'settings' => 'toc_title',
        'label' => '目次のタイトル',
        'type' => 'text',
    ]);

//ソースコードのハイライト
$wp_customize->add_section( 'code_highlight', array (
    'title' => 'ソースコードのハイライト表示',
));
    //読み込み方選択
    $wp_customize->add_setting( 'is_code_highlight', array (
        'default' => null,
    ));
    $wp_customize->add_control( 'is_code_highlight', array(
        'section' => 'code_highlight',
        'settings' => 'is_code_highlight',
        'label' => 'Highlight.jsの読み込み方',
        'type' => 'radio',
        'choices'    => [
            null => '読み込まない（デフォルト）',
            'all' => 'すべてのページで読み込み',
            'in_category' => '指定したカテゴリーに属するページだけ読み込み',
        ],
    ));
    //カテゴリー選択
    $wp_customize->add_setting( 'code_highlight_category', array (
        'default' => null,
    ));
    $wp_customize->add_control( 'code_highlight_category', array(
        'section' => 'code_highlight',
        'settings' => 'code_highlight_category',
        'label' => 'Highlight.jsを読み込むカテゴリー',
        'description' => 'IDかスラッグを入力してください。複数指定する場合は、半角コンマで区切って入力してください。指定したカテゴリ以外のページでHighlight.jsを読み込みません。',
        'type' => 'text',
    ));

//既存の設定項目に追加
    //サイトに表示するタイトル
    $wp_customize->add_setting( 'site_title', array (
        'default' => null,
    ));
    $wp_customize->add_control( 'site_title', array(
        'section' => 'title_tagline',
        'settings' => 'site_title',
        'label' =>'サイト上に表示するタイトル。',
        'description' => 'サイト上に表示するタイトルを変更できます（入力しない場合は、一般→「サイトタイトル」の文字が表示されます）。検索結果のサイトタイトルには、一般→「サイトタイトル」で入力した文字が使われます。',
        'type' => 'text',
    ));

//吹き出し
$wp_customize->add_section( 'balloon', array (
    'title' => '吹き出し',
));
    //左からの吹き出し
    $wp_customize->add_setting( 'balloon_left_image' );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'balloon_left_image', [
        'section' => 'balloon',
        'settings' => 'balloon_left_image',
        'label' => '左からの吹き出し画像',
        'priority' => 10,
    ]));
    //左figcaption
    $wp_customize->add_setting( 'balloon_left_figcaption', array (
        'default' => '画像の説明',
    ));
    $wp_customize->add_control( 'balloon_left_figcaption', array(
        'section' => 'balloon',
        'settings' => 'balloon_left_figcaption',
        'label' => '左吹き出し画像下の説明（初期状態）',
        'type' => 'text',
        'priority' => 10,
    ));
    //右からの吹き出し
    $wp_customize->add_setting( 'balloon_right_image' );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'balloon_right_image', [
        'section' => 'balloon',
        'settings' => 'balloon_right_image',
        'label' => '右からの吹き出し画像',
        'priority' => 50,
    ]));
    //右figcaption
    $wp_customize->add_setting( 'balloon_right_figcaption', array (
        'default' => '画像の説明',
    ));
    $wp_customize->add_control( 'balloon_right_figcaption', array(
        'section' => 'balloon',
        'settings' => 'balloon_right_figcaption',
        'label' => '右吹き出し画像下の説明（初期状態）',
        'type' => 'text',
        'priority' => 50,
    ));
    //画像サイズ
    $wp_customize->add_setting( 'balloon_image_size', [
        'default' => '60',
    ]);
    $wp_customize->add_control( 'balloon_image_size', [
        'section' => 'balloon',
        'settings' => 'balloon_image_size',
        'label' => '吹き出し画像の横幅',
        'type' => 'radio',
        'priority' => 100,
        'choices'    => [
            '60' => '60px',
            '80' => '80px',
            '100' => '100px',
        ],
    ]);
    //吹き出し画像加工
    $wp_customize->add_setting( 'balloon_image_style_option', [
        'default' => 'border_border_radius',
    ]);
    $wp_customize->add_control( 'balloon_image_style_option', [
        'section' => 'balloon',
        'settings' => 'balloon_image_style_option',
        'label' => '吹き出し画像のスタイル',
        'type' => 'radio',
        'priority' => 100,
        'choices'    => [
            null => '加工しない',
            'border_border_radius' => '画像を丸くして枠線をつける',
        ],
    ]);

//その他
$wp_customize->add_section( 'etc', array (
    'title' => 'その他',
));
    //JavaScriptの読み込み
    $wp_customize->add_setting( 'javascript_load', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'javascript_load', [
        'section' => 'etc',
        'settings' => 'javascript_load',
        'label' =>'JavaScriptの読み込み方法',
        'description' => '非同期で読み込むことでページの読み込み速度が上がりますが、不具合が生じる場合は同期的に読み込んでください。',
        'type' => 'radio',
        'choices'    => [
            null => '同期',
            'async' => '非同期（async）',
            'defer' => '非同期（defer）',
        ],
    ]);
    //カスタムブログカード
    $wp_customize->add_setting( 'custom_blogcard', [
        'default' => false,
    ]);
    $wp_customize->add_control( 'custom_blogcard', [
        'section' => 'etc',
        'settings' => 'custom_blogcard',
        'label' =>'ブログカード表示切り替え',
        'description' => 'オリジナルのブログカードに変更します。CSSで見た目を調整できます。',
        'type' => 'checkbox',
    ]);
    //コピー禁止
    $wp_customize->add_setting( 'copy_guard', [
        'default' => false,
    ]);
    $wp_customize->add_control( 'copy_guard', [
        'section' => 'etc',
        'settings' => 'copy_guard',
        'label' => 'コピーガード',
        'description' => 'サイト内のコンテンツを選択できないようにしてコピーを防ぎます。',
        'type' => 'checkbox',
    ]);
    //カエレバのタグ変換
    $wp_customize->add_setting( 'kaereba_convert', [
        'default' => 'amp',
    ]);
    $wp_customize->add_control( 'kaereba_convert', [
        'section' => 'etc',
        'settings' => 'kaereba_convert',
        'label' => 'カエレバのタグ変換',
        'type' => 'radio',
        'choices'    => [
            'amp' => 'AMPページだけ変換',
            'singular_amp' => 'AMPページと通常の記事ページ',
        ],
    ]);
    //カエレバのデザイン
    $wp_customize->add_setting( 'kaereba_design', [
        'default' => 'amp',
    ]);
    $wp_customize->add_control( 'kaereba_design', [
        'section' => 'etc',
        'settings' => 'kaereba_design',
        'label' => 'カエレバにオリジナルスタイルを適用',
        'type' => 'radio',
        'choices'    => [
            'amp' => 'AMPページだけ適用',
            'singular_amp' => 'AMPページと通常の記事ページ',
            null => '適用しない（自分でCSSを編集できる方向け）',
        ],
    ]);
    //ウィジェット自動生成解除
    $wp_customize->add_setting( 'is_widget_wpautop', [
        'default' => true,
    ]);
    $wp_customize->add_control( 'is_widget_wpautop', [
        'section' => 'etc',
        'settings' => 'is_widget_wpautop',
        'label' => 'ウィジェットの自動タグ追加機能',
        'description' => 'pタグやbrタグが自動で追加されないようにします。',
        'type' => 'checkbox',
    ]);


});

//カスタムヘッダー
$custom_header = [
    'random-default' => false,
    'width' => 640,
    'height' => 320,
    'flex-height' => true,
    'flex-width' => true,
    'default-text-color' => '',
    'header-text' => false,
    'uploads' => true,
    'default-image' => '',
];
add_theme_support( 'custom-header', $custom_header );
