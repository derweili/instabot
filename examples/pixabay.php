<?php

require dirname( dirname( __FILE__ ) ) . '/vendor/autoload.php';
require dirname( dirname( __FILE__ ) ) . '/config/config.php';

use \Derweili\Instabot\Services\VideoEditor;


$pixabayClient = new \Pixabay\PixabayClient([
	'key' => PIXABAY_API_KEY
]);

VideoEditor::setup( CLOUDINARY_CLOUD_NAME, CLOUDINARY_API_KEY, CLOUDINARY_API_SECRET );


// test it
// $results = $pixabayClient->get(['q' => 'nature'], true);
// $results = $pixabayClient->getVideos( ['q' => 'love', 'min_width' => 1080], true )
$results = $pixabayClient->getVideos(['q' => 'love', 'min_width' => 1080]);
// show the results
echo '<pre>';

$video_url = $results->hits[0]->videos->large->url;

$video_path = VideoEditor::getVideoWithInstagramSize(
  $video_url,
  TEMP_IMAGE_FOLDER
);

echo $video_path;
