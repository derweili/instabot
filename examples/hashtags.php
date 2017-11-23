<?php
require dirname( dirname( __FILE__ ) ) . '/vendor/autoload.php';
require dirname( dirname( __FILE__ ) ) . '/config/config.php';

use Derweili\Instabot\Services\Instagram;
use Derweili\Instabot\Services\Hashtags;
echo '<pre>';
$search_keys = ['nature', 'love'];
Instagram::setup_official_api( INSTAGRAM_API_KEY,INSTAGRAM_API_ACCESS_TOKEN );

$hashtags = Hashtags::get_popular_hashtags_by_search_terms($search_keys);

var_dump($hashtags);
