<?php

$number = mt_rand ( 1 , 4 );

if($number != 4){
  die('wird nicht ausgeführt');
}

require dirname( dirname( __FILE__ ) ) . '/vendor/autoload.php';
require dirname( dirname( __FILE__ ) ) . '/config/config.php';

use Derweili\Instabot\Services\Unsplash;
use Derweili\Instabot\Services\Database;
use Derweili\Instabot\Services\Download;
use Derweili\Instabot\Services\Instagram;
use Derweili\Instabot\Services\Resizer;
use Derweili\Instabot\Models\InstagramImage;
# Imports the Google Cloud client library
use Derweili\Instabot\Services\ImageDetection;
use Derweili\Instabot\Services\CaptionGenerator;
use Derweili\Instabot\Services\Hashtags;

echo '<pre>';

// setup all require stuff
Unsplash::setup(UNSPLASH_APPLICATION_ID, UNSPLASH_UTM_SOURCE);
Database::setup(FIREBASE_CONFIG_FILE_PATH);
Download::setup(TEMP_IMAGE_FOLDER);
ImageDetection::setup(VISION_CONFIG_PATH);

Instagram::setup(INSTAGRAM_USERNAME, INSTAGRAM_PASSWORD);
Instagram::setup_official_api( INSTAGRAM_API_KEY,INSTAGRAM_API_ACCESS_TOKEN );

$search = $_GET['search'] ? $_GET['search'] : 'love';


// search for image by keyword
$image = Unsplash::searchByKeyword($search);

echo 'unsplash image: ';
var_dump($image);

// echo "<img src='{$image->image_url}' />";




// download image to temp folder
$path = Download::download_image($image);

echo '<br>original Image path: ' . $path . ' <br>';


$square_image_path = Resizer::cropImageToIntagramDimensions($path);

echo 'square Image path: ' . $square_image_path . ' <br>';

/*
 * Image Content Detection
 */
$topics = ImageDetection::getImageInfo($square_image_path);
$topics_array = ImageDetection::topcisToArray($topics);

echo '<h1>topics</h1>';
// $topics_array[] = 'love';
var_dump($topics_array);
$hashtags = Hashtags::get_popular_hashtags_by_search_terms($topics_array);
echo '<h1>$hashtags</h1>';
// $topics_array[] = 'love';
var_dump($hashtags);
$caption = CaptionGenerator::generate_hashtag_string($hashtags);


echo 'Hashtags: ' . $hashtags . ' <br>';



$post_return = Instagram::postImage($square_image_path, $caption);


$instagram_post = new InstagramImage();

$instagram_post->saveFromInstagramResponse($post_return);




echo '<hr>';



// save image within database
$return = Database::store_image($image);

$return = Database::store_post($instagram_post, $image, $topics_array);
