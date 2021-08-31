<?php
function thumbnail_4536($thumbnail_style)
{
    $thumbnail = '';
    $src = '';
    $class = '';

    if (thumbnail_size()=='thumbnail-wide') {
        $thumb500 = [500,375];
        $thumb300 = [300,225];
        $thumb150 = [150,113];
        $thumb100 = [100,75];
    } elseif (thumbnail_size()=='thumbnail') {
        $thumb500 = [500,500];
        $thumb300 = [300,300];
        $thumb150 = [150,150];
        $thumb150 = [100,100];
    }

    $thumbnail_class = thumbnail_size();

    switch ($thumbnail_style) {
      case '2-5':
      case 'big':
        $size = $thumb500;
        break;
      case '3-3':
      case '4-2':
        $size = $thumb300;
        break;
      case 'pickup':
      case 'widget':
        $size = $thumb150;
        break;
      case 'music':
        $thumbnail_class = 'thumbnail-music-4536';
        $size = [150, 150];
        break;
      case 'movie':
        $thumbnail_class = 'thumbnail-movie-4536';
        $size = [196, 110];
        break;
      default:
        break;
    }

    if (is_amp()) {
        $size = $thumb500;
    }

    $post_thumbnail = get_the_post_thumbnail($post->ID, $size);

    //サムネイル
    $start_tag = '<figure data-position="relative" class="post-thumbnail w-100 ' . $thumbnail_class . '">';
    $thumbnail = (has_post_thumbnail()) ? $post_thumbnail : get_some_image_4536( get_the_content() );
    $end_tag = '</figure>';
    $thumbnail = $start_tag.$thumbnail.$end_tag;
    $thumbnail = convert_content_to_amp($thumbnail);
    return [
        'thumbnail' => $thumbnail,
        'src' => $src,
        'class' => $class
    ];
}
