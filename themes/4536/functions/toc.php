<?php // 参考ページ：https://github.com/yusukemurayama/blog-samples/blob/master/wordpress_outline/functions.php

function get_outline_info_4536($content)
{
    $outline = '';
    $search_level = '1-2';
    if (toc_headline_level()==='h3') {
        $search_level = '1-3';
    }
    if (toc_headline_level()==='h4') {
        $search_level = '1-4';
    }
    if (toc_headline_level()==='h5') {
        $search_level = '1-5';
    }
    $search = '/<h(['.$search_level.'])>(.*?)<\/h\1>/';
    if (preg_match_all($search, $content, $matches, PREG_SET_ORDER)) {
        $num = count($matches);
        $i = toc_headline_count();
        if ($num < $i) {
            return array('content' => $content, 'outline' => $outline);
        }
        $min_level = min(array_map(function ($m) {
            return $m[1];
        }, $matches));
        $current_level = $min_level - 1;
        $sub_levels = array('1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0);
        foreach ($matches as $m) {
            $level = $m[1];
            // $dot = ($level > 2) ? '' : '<div class="dot"><dot class="dot_inner"></dot></div>';
            $text = strip_tags($m[2]);
            while ($current_level > $level) {
                $current_level--;
                $outline .= '</li></ul>';
            }
            if ($current_level == $level) {
                $outline .= '</li><li data-position="relative" data-display="flex" data-align-items="center">';
            } else {
                while ($current_level < $level) {
                    $current_level++;
                    if( $current_level > 2 ) {
                      $ul_class = 'children ';
                    } elseif ( $current_level === 2 ) {
                      $ul_class = 'toc-parent ';
                    }
                    $outline .= sprintf('<ul class="' . $ul_class . 'indent-%s"><li data-position="relative" data-display="flex" data-align-items="center">', $current_level);
                }
                for ($idx = $current_level + 0; $idx < count($sub_levels); $idx++) {
                    $sub_levels[$idx] = 0;
                }
            }
            $sub_levels[$current_level]++;
            $level_fullpath = array();
            for ($idx = $min_level; $idx <= $level; $idx++) {
                $level_fullpath[] = $sub_levels[$idx];
            }

            $depth_num = implode('-', $level_fullpath);
            $target_anchor_toc = '#outline-' . $depth_num;
            $target_anchor_content = 'outline-' . $depth_num;
            $dot = ( ctype_digit($depth_num) ) ? '<div class="dot body-bg-color mr-2"><div data-display="flex" data-justify-content="center" data-align-items="center" class="dot_inner gradation">' . $depth_num . '</div></div>' : '';
            $outline .= $dot;
            $outline .= sprintf('<a data-display="flex" href="%s" class="flex-1">%s</a>', $target_anchor_toc, $text);
            $content = preg_replace('/<h(['.$search_level.'])>/', '<h\1 id="' . $target_anchor_content . '">', $content, 1);
        }
        $search = '/<h(['.$search_level.'])\s(.*?)>(.*?)<\/h\1>/';
        $content = preg_replace($search, '<h\1><span $2>$3</span></h\1>', $content);
        while ($current_level >= $min_level) {
            $outline .= '</li></ul>';
            $current_level--;
        }
    }
    return array('content' => $content, 'outline' => $outline);
}

function table_of_contents_4536($content)
{
    if (strtolower(get_post_meta(get_the_ID(), 'disable_outline', true)) == 'true') {
        return $content;
    }
    if (!is_toc_4536()) {
        return $content;
    }
    global $post;
    if (get_post_meta($post->ID, 'toc', true)) {
        return $content;
    }
    $outline_info = get_outline_info_4536($content);
    $content = $outline_info['content'];
    $outline = $outline_info['outline'];
    if (!$outline) {
        return $content;
    }
    $outline = '<hr class="section-break mt-5 mb-5" /><div data-display="flex" data-justify-content="center"><div class="toc-4536 md9"><div data-text-align="center" class="headline mb-3">'.toc_title().'</div>'.$outline.'</div></div><hr class="section-break mt-5 mb-5" />';
    $match = preg_match('/<h[1-6].*>/', $content, $matches, PREG_OFFSET_CAPTURE);
    if ($outline && $match) {
        $pos = $matches[0][1];
        $content = substr($content, 0, $pos) . $outline . substr($content, $pos);
    }
    return $content;
}
add_filter('the_content', 'table_of_contents_4536', 9999999999);

function is_toc_4536()
{ // 目次条件分岐
    $toc = false;
    $is_custom_post = is_singular(['music','movie']);
    if (
        (is_toc()==='single' && is_single() && !$is_custom_post) ||
        (is_toc()==='page' && is_page()) ||
        (is_toc()==='single_page' && is_singular(['post','page']) && !$is_custom_post) ||
        (is_toc()==='singular' && is_singular())
    ) {
        $toc = true;
    }
    return $toc;
}
