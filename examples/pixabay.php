<?php

require dirname( dirname( __FILE__ ) ) . '/vendor/autoload.php';
require dirname( dirname( __FILE__ ) ) . '/config/config.php';

use \Derweili\Instabot\Services\Pixabay;
use Derweili\Instabot\Services\Database;

use Derweili\Instabot\Services\Instagram;
use Derweili\Instabot\Services\Hashtags;

use \Derweili\Instabot\Services\VideoEditor;

use Derweili\Instabot\Services\CaptionGenerator;


Instagram::setup_official_api( INSTAGRAM_API_KEY,INSTAGRAM_API_ACCESS_TOKEN );
Database::setup(FIREBASE_CONFIG_FILE_PATH);
Pixabay::setup(PIXABAY_API_KEY);
VideoEditor::setup( CLOUDINARY_CLOUD_NAME, CLOUDINARY_API_KEY, CLOUDINARY_API_SECRET );
// Instagram::setup(INSTAGRAM_USERNAME, INSTAGRAM_PASSWORD);


echo '<pre>';

// $result = Pixabay::getVideosByKeyword('wildnes');
$search = 'love';
$video = Pixabay::searchVideosByKeyword($search);

$hashtags = Hashtags::get_popular_hashtags_by_search_terms($video->tags);

echo '<br>hashtags:<br>';
var_dump($hashtags);


$hashtags = CaptionGenerator::generate_hashtag_string($hashtags);

echo '<br>hashtags:<br>';
var_dump($hashtags);


// var_dump($video);

// echo '<h2>Hashtags:</h2>';
// var_dump($hashtags);



$video_path = VideoEditor::getVideoWithInstagramSize(
  'https://pixabay.com/de/videos/download/video-4929_large.mp4',
  TEMP_IMAGE_FOLDER
);
echo '<br>';
echo $video_path;

//
// // post image
// $post_return = Instagram::postVideo($video_path, $hashtags);
//
//
// $instagram_post = new InstagramVideo();
// $instagram_post->saveFromInstagramResponse($post_return);
//
//
//
//
// // save image within database
// $return = Database::store_video($video);
//
// $return = Database::store_post($instagram_post, $image, $topics_array);
