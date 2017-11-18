<?php

namespace Derweili\Instabot\Services;
use \Cloudinary;
use \Cloudinary\Uploader;
use \Derweili\Instabot\Services\Instagram;
use \Derweili\Instabot\Services\Download;

/**
 *
 */
class VideoEditor
{


  static public function setup( $cloud_name, $api_key, $api_secret ){
    Cloudinary::config( array(
      "cloud_name" => $cloud_name,
      "api_key" => $api_key,
      "api_secret" => $api_secret
    ) );
  }

  /*
   * @param $video | can be absolute path or url
   */
  static public function cropVideoToInstagramDimensions( $video ){
    $video_data = Uploader::upload(
      $video,
      array(
        "resource_type" => "video",
        "eager" => array(
          array(
            "width" => Instagram::$video_width,
            "height" => Instagram::$video_height,
            "crop" => "fill",
          )
        ),
      )
    );
    return $video_data;
  }

  /*
   *
   */
  static public function getVideoWithInstagramSize( $video, $path ){
    $video_data = self::cropVideoToInstagramDimensions($video);
    $path = $path . '/' . $video_data["original_filename"] . '.' . $video_data["format"];
    // var_dump($video_data);
    $video_path = Download::downloadFile($video_data['eager'][0]['url'], $path);
    return $path;
  }

}
