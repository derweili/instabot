<?php

namespace Derweili\Instabot\Services;
use \Eventviva\ImageResize;

/**
 *
 */
class Resizer
{
  static private $instagram_photo_width = 1080;
  static private $instagram_photo_height = 1080;

  static private $instagram_story_width = 1080;
  static private $instagram_story_height = 1920;

  static public function cropImageToIntagramDimensions($path){
    self::cropImageSaveJpg($path, self::$instagram_photo_width, self::$instagram_photo_height);
    return $path . '.jpg';
  }

  static public function cropImageToIntagramStoryDimensions($path){
    self::cropImageSaveJpg($path, self::$instagram_story_width, self::$instagram_story_height);
    return $path . '.jpg';
  }

  static private function cropImageSaveJpg(string $path, $width, $height){
    try{
      $image = new ImageResize($path);
      $image->crop($width, $height);
      $image->save($path . '.jpg', IMAGETYPE_JPEG);
    } catch (ImageResizeException $e) {
      echo "Something went wrong" . $e->getMessage();
    }
  }

}
