<?php


require dirname( dirname( __FILE__ ) ) . '/vendor/autoload.php';
require dirname( dirname( __FILE__ ) ) . '/config/config.php';

use Derweili\Instabot\Services\Instagram;
# Imports the Google Cloud client library
use Derweili\Instabot\Services\ImageDetection;
use Derweili\Instabot\Services\CaptionGenerator;


$video_path = '/Users/arbeitsplatz17/websites/instabot/temp/video-4929_large.mp4';

$hashtags = '#lovequotes #lovekittens #loveforever #lovemakeup #lovedogs #lovelife #lovemyjob #loveyourself #lovemydog #lovemylife #lovelyday #lovers #love #lovewhatido #lovemyboys #lovestory #loveislove #hearts #lovelovelove #lovepuppies ';

Instagram::setup(INSTAGRAM_USERNAME, INSTAGRAM_PASSWORD);

$post_return = Instagram::postVideo($video_path, $hashtags);

echo '<h1>Post return:</h1>';

var_dump( $post_return );
