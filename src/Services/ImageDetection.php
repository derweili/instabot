<?php

namespace Derweili\Instabot\Services;
use Google\Cloud\Vision\VisionClient;

/**
 *
 */
class ImageDetection
{
  static private $vision;

  /*
   * @param $keyFilePath string
   */
  static public function setup( $keyFilePath ){
    # Instantiates a client
    self::$vision = new VisionClient([
         'keyFilePath' => $keyFilePath
    ]);

  }

  /*
   * @param $image_path string
   */
  static public function getImageInfo( $image_path ){
    # Prepare the image to be annotated
    $image = self::$vision->image(fopen($image_path, 'r'), [
        'LABEL_DETECTION'
    ]);


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
