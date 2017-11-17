<?php

$number = mt_rand ( 1 , 4 );

if($number != 4){
  // die('wird nicht ausgeführt');
}

require dirname( dirname( __FILE__ ) ) . '/vendor/autoload.php';
require dirname( dirname( __FILE__ ) ) . '/config/config.php';


# Imports the Google Cloud client library
use Derweili\Instabot\Services\ImageDetection;
use Derweili\Instabot\Services\CaptionGenerator;

echo '<pre>';

$test_image = dirname( dirname( __FILE__ ) ) . '/temp/unsplash_seflsefilsef.jpg';


ImageDetection::setup(VISION_CONFIG_PATH);

$topics = ImageDetection::getImageInfo($test_image);
$topics_array = ImageDetection::topcisToArray($topics);
var_dump($topics_array);
echo CaptionGenerator::generate_hashtag_string($topics_array);
