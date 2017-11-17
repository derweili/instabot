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

echo '<pre>';

// setup unsplash credentials
Unsplash::setup(UNSPLASH_APPLICATION_ID, UNSPLASH_UTM_SOURCE);
Database::setup(FIREBASE_CONFIG_FILE_PATH);
Download::setup(TEMP_IMAGE_FOLDER);
// Instagram::setup(INSTAGRAM_USERNAME, INSTAGRAM_PASSWORD);

$search = $_GET['search'] ? $_GET['search'] : 'love';


// search for image by keyword
$image = Unsplash::searchByKeyword($search);

echo 'unsplash image: ';
var_dump($image);

// echo "<img src='{$image->image_url}' />";


die();
// save image within database
$return = Database::store_image($image);

var_dump($return);


$return = Download::download_image($image);

echo $return;

$return = Resizer::cropImageToIntagramDimensions($return);

echo $return;

$post_return = Instagram::postImage($return, '#Christmas #love');


$instagram_post = new InstagramImage();

$instagram_post->saveFromInstagramResponse($post_return);

$return = Database::store_post($instagram_post, $image);



echo '<hr>';
var_dump($return);
