<?php
register_sidebar([
    'name' => 'サイドバー',
    'id' => 'sidebar',
    'before_widget' => '<div class="widget-4536 w-100 %1$s %2$s sidebar-widget mb-5">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="widget-title headline mb-3 post-color" data-text-align="center">',
    'after_title' => '</h3>',
]);
register_sidebar([
    'name' => 'スクロール',
    'id' => 'scroll-sidebar',
    'description' => 'PC表示時スクロール',
    'before_widget' => '<div class="widget-4536 w-100 %1$s %2$s sidebar-widget mb-5">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="widget-title headline mb-3 post-color" data-text-align="center">',
    'after_title' => '</h3>',
]);
register_sidebar([
    'name' => 'ヘッダー',
    'id' => 'header-widget',
    'description' => 'サイトタイトルやメニューの下部分に表示されます。',
    'before_widget' => '<div class="%1$s header-widget mt-5 mb-5 pa-3"><div data-position="relative" class="widget-4536 container ma-auto w-100 %2$s">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="headline mb-2 post-color" data-text-align="center">',
    'after_title' => '</div>',
]);
register_sidebar([
    'name' => '記事上',
    'id' => 'post-top-widget',
    'description' => '本文上に表示されます。',
    'before_widget' => '<div class="widget-4536 w-100 %1$s %2$s post-top-widget mb-4">',
    'after_widget' => '</div>',
    'before_title' => '<div class="meta mb-2 post-color" data-text-align="center">',
    'after_title' => '</div>',
]);
register_sidebar([
    'name' => '記事中',
    'id' => 'sp-first-h2-ad',
    'description' => '本文中の最初のh2タグの手前に表示されます。広告掲載に最適な位置です。',
    'before_widget' => '<div class="widget-4536 w-100 %1$s %2$s post-h2-widget mt-5 mb-5" data-text-align="center">',
    'after_widget' => '</div>',
    'before_title' => '<div class="meta mb-2 post-color">',
    'after_title' => '</div>',
]);
register_sidebar([
    'name' => '記事下広告枠',
    'id' => 'ad',
    'description' => '本文の真下に表示されます。広告掲載に最適な位置です。',
    'before_widget' => '<div class="widget-4536 w-100 %1$s %2$s post-bottom-ad-widget mt-5" data-text-align="center">',
    'after_widget' => '</div>',
    'before_title' => '<div class="meta mb-2 post-color">',
    'after_title' => '</div>',
]);
register_sidebar([
    'name' => '記事下',
    'id' => 'post-bottom',
    'description' => '本文下のカテゴリーの後ろに表示されます。CTAや関連コンテンツユニットの掲載におすすめです。',
    'before_widget' => '<div class="widget-4536 w-100 %1$s %2$s post-bottom-widget mt-5">',
    'after_widget' => '</div>',
    'before_title' => '<div class="headline mb-2 post-color" data-text-align="center">',
    'after_title' => '</div>',
]);
// register_sidebar([
//     'name' => 'フッター上',
//     'id' => 'footer',
//     'description' => 'サイト下部に表示されます。「設定」から幅を変更できます。',
//     'before_widget' => '<div class="widget-4536 w-100 %1$s %2$s footer-widget">',
//     'after_widget' => '</div>',
//     'before_title' => '<div class="widget-title">',
//     'after_title' => '</div>',
// ]);
register_sidebar([
    'name' => 'フッター',
    'id' => 'footer',
    'description' => 'サイト最下部に表示されます。PC表示時は上から順に横並び',
    'before_widget' => '<div class="widget-4536 flex-1 xs12 sm12 %1$s %2$s footer-widget pa-3 mb-4">',
    'after_widget' => '</div>',
    'before_title' => '<div class="headline mb-3 post-color">',
    'after_title' => '</div>',
]);
register_sidebar([
    'name' => '固定フッター',
    'id' => 'fixed-footer',
    'description' => 'テーマカスタマイザー（外観→カスタマイズ）で固定フッターを「オーバーレイ広告」にすると表示されます。高さ50pxまで。「空のアイテム」を使ってください。',
    'before_widget' => '<div class="widget-4536 w-100 %1$s %2$s fixed-footer-widget">',
    'after_widget' => '</div>',
]);
register_sidebar([
    'name' => '一覧記事インフィード広告',
    'id' => 'infeed-ad',
    'description' => '一覧記事中でランダムに表示されます。サイトのデザインに合わせた広告を掲載してください。',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<div class="meta mb-2 post-color">',
    'after_title' => '</div>',
]);
register_sidebar([
    'name' => 'AMPヘッダー',
    'id' => 'amp-header',
    'description' => '※コードを貼り付ける場合はAMP対応のタグをお使いください。',
    'before_widget' => '<div class="%1$s header-widget amp-header-widget mt-5 mb-5 pa-3"><div data-position="relative" class="widget-4536 container ma-auto w-100 w-100 %2$s">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="headline mb-2 post-color" data-text-align="center">',
    'after_title' => '</div>',
]);
register_sidebar([
    'name' => 'AMP記事上',
    'id' => 'amp-post-top',
    'description' => '※コードを貼り付ける場合はAMP対応のタグをお使いください。',
    'before_widget' => '<div class="widget-4536 w-100 %1$s %2$s post-top-widget amp-post-top-widget mb-4">',
    'after_widget' => '</div>',
    'before_title' => '<div class="meta mb-2 post-color" data-text-align="center">',
    'after_title' => '</div>',
]);
register_sidebar([
    'name' => 'AMP記事中',
    'id' => 'amp-first-h2-ad',
    'description' => '投稿本文中の最初のH2タグの手前に表示されます。※コードを貼り付ける場合はAMP対応のタグをお使いください。',
    'before_widget' => '<div class="widget-4536 w-100 %1$s %2$s post-h2-widget mt-5 mb-5" data-text-align="center">',
    'after_widget' => '</div>',
    'before_title' => '<div class="meta mb-2 post-color">',
    'after_title' => '</div>',
]);
register_sidebar([
    'name' => 'AMP記事下広告枠',
    'id' => 'amp-post-ad',
    'description' => '※コードを貼り付ける場合はAMP対応のタグをお使いください。',
    'before_widget' => '<div class="widget-4536 w-100 %1$s %2$s post-bottom-ad-widget mt-5" data-text-align="center">',
    'after_widget' => '</div>',
    'before_title' => '<div class="meta mb-2 post-color">',
    'after_title' => '</div>',
]);
register_sidebar([
    'name' => 'AMP記事下',
    'id' => 'amp-post-bottom',
    'description' => '※コードを貼り付ける場合はAMP対応のタグをお使いください。',
    'before_widget' => '<div class="widget-4536 w-100 %1$s %2$s post-bottom-widget mt-5">',
    'after_widget' => '</div>',
    'before_title' => '<div class="headline mb-2 post-color" data-text-align="center">',
    'after_title' => '</div>',
]);
register_sidebar([
    'name' => 'AMPサイドバー',
    'id' => 'amp-sidebar',
    'description' => '※コードを貼り付ける場合はAMP対応のタグをお使いください。',
    'before_widget' => '<div class="widget-4536 w-100 %1$s %2$s sidebar-widget mb-5">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="widget-title headline mb-3 post-color" data-text-align="center">',
    'after_title' => '</h3>',
]);
register_sidebar([
    'name' => 'AMP固定フッター',
    'id' => 'amp-fixed-footer',
    'description' => '固定フッターを「オーバーレイ広告」にすると表示されます。高さ50pxまで。amp-adタグを「空のアイテム」に入力して使ってください。それ以外のタグはすべてエラーになります。',
    'before_widget' => '<div class="widget-4536 w-100 %1$s %2$s fixed-footer-widget">',
    'after_widget' => '</div>',
]);
