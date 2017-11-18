<?php

namespace Derweili\Instabot\Services;
use Google\Cloud\VideoIntelligence\V1beta1\VideoIntelligenceServiceClient;
use Google\Cloud\Videointelligence\V1beta1\Feature;

/**
 *
 */
class VideoDetection
{
  static private $vision;

  /*
   * @param $keyFilePath string
   */
  static public function setup( $keyFilePath ){
    # Instantiates a client
    self::$video_intelligence = new VideoIntelligenceServiceClient([
         'keyFilePath' => $keyFilePath
    ]);

  }

  /*
   * @param $image_path string
   */
  static public function getVideoInfo( $image_path ){
    # Prepare the image to be annotated
    $operation = self::$video_intelligence->annotateVideo(fopen($image_path, 'r'),
      [Feature::LABEL_DETECTION]
    );

    # Wait for the request to complete.
    $operation->pollUntilComplete();

    if (!$operation->operationSucceeded()) {
      print_r($operation->getError());
      die;
    }

    # Performs label detection on the image file
    $labels = self::$vision->annotate($image)->labels();
    return $labels;
  }

  static public function topcisToArray( $topics ){
    $return = array();
    foreach ($topics as $topic ) {
      $return[] = $topic->description();
    }
    return $return;
  }

}
