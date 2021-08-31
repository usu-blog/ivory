<?php //参考：https://nelog.jp/wordpress-tinymce-custom
add_filter('tiny_mce_before_init', function($init_array) {
    $style_formats = [
        [
            'title' => '文字の色',
            'items' => [
                [
                    'title' => '赤文字',
                    'inline' => 'span',
                    'classes' => 'color-red-4536'
                ],
                [
                  'title' => '青文字',
                  'inline' => 'span',
                  'classes' => 'color-blue-4536'
                ],
                [
                  'title' => 'オレンジ文字',
                  'inline' => 'span',
                  'classes' => 'color-orange-4536'
                ],
                [
                  'title' => '緑文字',
                  'inline' => 'span',
                  'classes' => 'color-green-4536'
                ],
                [
                  'title' => '白文字',
                  'inline' => 'span',
                  'classes' => 'color-white-4536'
                ],
                ],
            ],
        [
            'title' => '文字の背景色',
            'items' => [
                [
                  'title' => '赤背景',
                  'inline' => 'span',
                  'classes' => 'background-color-red'
                ],
                [
                  'title' => '青背景',
                  'inline' => 'span',
                  'classes' => 'background-color-blue'
                ],
                [
                  'title' => 'オレンジ背景',
                  'inline' => 'span',
                  'classes' => 'background-color-orange'
                ],
                [
                  'title' => '緑背景',
                  'inline' => 'span',
                  'classes' => 'background-color-green'
                ],
                ],
            ],
        [
            'title' => '文字装飾',
            'items' => [
                [
                    'title' => '太字（装飾）',
                    'inline' => 'span',
                    'classes' => 'bold-4536'
                ],
                [
                    'title' => '下線',
                    'inline' => 'span',
                    'classes' => 'underline-4536'
                ],
                [
                    'title' => '打ち消し線（装飾）',
                    'inline' => 'span',
                    'classes' => 'line-through-4536'
                ],
                [
                    'title' => '影をつける',
                    'inline' => 'span',
                    'classes' => 'text-shadow-4536'
                ],
                ],
            ],
        [
            'title' => '文字の大きさ',
            'items' => [
                [
                  'title' => '10px',
                  'inline' => 'span',
                  'classes' => 'font-size-10px'
                ],
                [
                  'title' => '12px',
                  'inline' => 'span',
                  'classes' => 'font-size-12px'
                ],
                [
                  'title' => '14px',
                  'inline' => 'span',
                  'classes' => 'font-size-14px'
                ],
                [
                  'title' => '16px',
                  'inline' => 'span',
                  'classes' => 'font-size-16px'
                ],
                [
                  'title' => '18px',
                  'inline' => 'span',
                  'classes' => 'font-size-18px'
                ],
                [
                  'title' => '20px',
                  'inline' => 'span',
                  'classes' => 'font-size-20px'
                ],
                [
                  'title' => '22px',
                  'inline' => 'span',
                  'classes' => 'font-size-22px'
                ],
                [
                  'title' => '24px',
                  'inline' => 'span',
                  'classes' => 'font-size-24px'
                ],
                ],
            ],
        [
            'title' => '枠で囲む',
            'items' => [
                [
                  'title' => '黒枠で囲む',
                  'block' => 'div',
                  'classes' => 'box-4536 border-4536'
                ],
                [
                  'title' => '赤枠で囲む',
                  'block' => 'div',
                  'classes' => 'box-4536 border-4536 border-red'
                ],
                [
                  'title' => '青枠で囲む',
                  'block' => 'div',
                  'classes' => 'box-4536 border-4536 border-blue'
                ],
                [
                  'title' => 'オレンジ枠で囲む',
                  'block' => 'div',
                  'classes' => 'box-4536 border-4536 border-orange'
                ],
                [
                  'title' => '緑枠で囲む',
                  'block' => 'div',
                  'classes' => 'box-4536 border-4536 border-green'
                ],
                ],
            ],
        [
            'title' => 'ボックス',
            'items' => [
                [
                    'title' => 'グレーのボックス',
                    'block' => 'div',
                    'classes' => 'box-4536 background-color-gray'
                ],
                [
                    'title' => '赤色のボックス',
                    'block' => 'div',
                    'classes' => 'box-4536 background-color-red'
                ],
                [
                    'title' => '青色のボックス',
                    'block' => 'div',
                    'classes' => 'box-4536 background-color-blue'
                ],
                [
                    'title' => 'オレンジのボックス',
                    'block' => 'div',
                    'classes' => 'box-4536 background-color-orange'
                ],
                [
                    'title' => '緑色のボックス',
                    'block' => 'div',
                    'classes' => 'box-4536 background-color-green'
                ],
                ],
            ],
        [
            'title' => 'ボタン',
            'items' => [
                [
                    'title' => 'オレンジのボタン',
                    'block' => 'div',
                    'classes' => 'button-4536 background-color-orange'
                ],
                [
                    'title' => '緑色のボタン',
                    'block' => 'div',
                    'classes' => 'button-4536 background-color-green'
                ],
                [
                    'title' => '青色のボタン',
                    'block' => 'div',
                    'classes' => 'button-4536 background-color-blue'
                ],
                [
                    'title' => '赤色のボタン',
                    'block' => 'div',
                    'classes' => 'button-4536 background-color-red'
                ],
                [
                    'title' => 'ボタンを光らせる',
                    'block' => 'div',
                    'classes' => 'is-reflection'
                ],
                [
                    'title' => 'ボタンをバウンドさせる',
                    'block' => 'div',
                    'classes' => 'is-bounce'
                ],
                ],
            ],
        [
            'title' => 'その他',
            'items' => [
                [
                    'title' => '「参考」や「関連」などの文字装飾に',
                    'inline' => 'span',
                    'classes' => 'reference'
                ],
                ],
            ],
    ];
    $init_array['style_formats'] = json_encode($style_formats);
    return $init_array;
}, 10000);

add_filter('mce_buttons', function($buttons) {
    $temp = array_shift($buttons);
    array_unshift($buttons, 'styleselect');
    array_unshift($buttons, $temp);
    return $buttons;
});
