<?php

$number = mt_rand ( 1 , 4 );

if($number != 4){
  // die('wird nicht ausgeführt');
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

echo '<pre>';

// setup all require stuff
Unsplash::setup(UNSPLASH_APPLICATION_ID, UNSPLASH_UTM_SOURCE);
Database::setup(FIREBASE_CONFIG_FILE_PATH);
Download::setup(TEMP_IMAGE_FOLDER);
ImageDetection::setup(VISION_CONFIG_PATH);

// Instagram::setup(INSTAGRAM_USERNAME, INSTAGRAM_PASSWORD);

$search = $_GET['search'] ? $_GET['search'] : 'love';


// search for image by keyword
$image = Unsplash::searchByKeyword($search);

echo 'unsplash image: ';
var_dump($image);

// echo "<img src='{$image->image_url}' />";



// save image within database
$return = Database::store_image($image);

var_dump($return);

// download image to temp folder
$path = Download::download_image($image);

/*
 * Image Content Detection
 */
$topics = ImageDetection::getImageInfo($test_image);
$topics_array = ImageDetection::topcisToArray($topics);
$hashtags = CaptionGenerator::generate_hashtag_string($topics_array);

$hashtags .= '#love';

echo $return;

$square_image_path = Resizer::cropImageToIntagramDimensions($path);

echo $return;

$post_return = Instagram::postImage($square_image_path, $hashtags);


$instagram_post = new InstagramImage();

$instagram_post->saveFromInstagramResponse($post_return);

$return = Database::store_post($instagram_post, $image);



echo '<hr>';
var_dump($return);
