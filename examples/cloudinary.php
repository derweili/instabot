<?php

require dirname( dirname( __FILE__ ) ) . '/vendor/autoload.php';
require dirname( dirname( __FILE__ ) ) . '/config/config.php';

use \Derweili\Instabot\Services\VideoEditor;

VideoEditor::setup( CLOUDINARY_CLOUD_NAME, CLOUDINARY_API_KEY, CLOUDINARY_API_SECRET );

$video_path = VideoEditor::getVideoWithInstagramSize(
  'https://pixabay.com/de/videos/download/video-4929_large.mp4',
  TEMP_IMAGE_FOLDER
);

var_dump($video_path);
