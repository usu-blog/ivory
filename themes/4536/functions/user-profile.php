<?php

// ユーザープロフィールの項目のカスタマイズ
add_filter('user_contactmethods', function($sns) {
	$sns['soundcloud'] = 'SoundCloud（soundcloud.com/以降）';
	$sns['spotify'] = 'Spotify（spotify.com/user/以降）';
	$sns['twitter'] = 'Twitter（twitter.com/以降）';
	$sns['facebook'] = 'Facebook（facebook.com/以降）';
	$sns['googleplus'] = 'Google+（plus.google.com/以降）';
	$sns['instagram'] = 'Instagram（instagram.com/以降）';
	$sns['fb_app_id'] = 'FacebookアプリID';
	return $sns;
});

//function get_twitter() { return get_the_author_meta('twitter'); }
//function get_soundcloud() { return get_the_author_meta('soundcloud'); }
//function get_spotify() { return get_the_author_meta('spotify'); }
//function get_facebook() { return get_the_author_meta('facebook'); }
//function get_googleplus() { return get_the_author_meta('googleplus'); }
//function get_instagram() { return get_the_author_meta('instagram'); }