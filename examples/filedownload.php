<?php
require dirname( dirname( __FILE__ ) ) . '/vendor/autoload.php';
require dirname( dirname( __FILE__ ) ) . '/config/config.php';

use Derweili\Instabot\Services\Database;
use Derweili\Instabot\Services\Download;
use Derweili\Instabot\Services\Instagram;
use Derweili\Instabot\Services\Resizer;


echo TEMP_IMAGE_FOLDER;
echo '<pre>';

// setup unsplash credentials
Download::setup(TEMP_IMAGE_FOLDER);
Instagram::setup(INSTAGRAM_USERNAME, INSTAGRAM_PASSWORD);

$image = new class {
    public $id = 'unsplash_seflsefilsef';
    public $image_url = "https://images.unsplash.com/photo-1435783099294-283725c37230";
};

$return = Download::download_image($image);

echo $return;

$return = Resizer::cropImageToIntagramDimensions($return);

echo $return;

$return = Instagram::postImage($return, '#Christmas #love');
echo '<hr>';
var_dump($return);

//var_dump($return);
