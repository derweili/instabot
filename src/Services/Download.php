<?php

namespace Derweili\Instabot\Services;
use Derweili\Instabot\Models\Photo;
use Derweili\Instabot\Services\Database;


/**
 *
 */
class Download
{

  static public $image_folder_path;

  static public function setup($path){
    self::$image_folder_path = $path;
  }

  static public function download_image( $image ){
    self::downloadFile( $image->image_url, self::$image_folder_path . '/' . $image->id );
    return self::$image_folder_path . '/' . $image->id;
  }

  static private function downloadFile( $url, $path )
  {
      $newfname = $path;
      $file = fopen ($url, 'rb');
      if ($file) {
          $newf = fopen ($newfname, 'wb');
          if ($newf) {
              while(!feof($file)) {
                  fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
              }
          }
      }
      if ($file) {
          fclose($file);
      }
      if ($newf) {
          fclose($newf);
      }
      return $newf;
  }

}
