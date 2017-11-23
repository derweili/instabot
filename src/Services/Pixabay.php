<?php

namespace Derweili\Instabot\Services;
use Derweili\Instabot\Models\Video;
use Derweili\Instabot\Models\Photo;
use Derweili\Instabot\Services\Database;

/**
 * Unplass API Service
 */
class Pixabay
{

  static public $source_id = 'pixabay';
  static public $source_name = 'pixabay';
  static public $keyword;
  static public $images;
  static private $maximum_page_iterations = 10;
  static public $used_video_ids = array();
  static private $pixabayClient;

  /*
   * @param array $result
   */
  static private $result;

  static public function setup( string $pixabayKey )
  {
    self::$pixabayClient = new \Pixabay\PixabayClient([
    	'key' => $pixabayKey
    ]);
  }

  static public function searchByKeyword( string $keyword, $used_image_ids = array() ){

    echo 'serach by keyword';
    self::$used_image_ids = Database::getStoredImageIDs();

    echo 'used image ids:';
    var_dump(self::$used_image_ids);
    return self::catchAndLoopThroughImages($keyword);

  }

  static public function searchVideosByKeyword( string $keyword, $used_image_ids = array() ){

    echo 'serach videos by keyword';
    self::$used_video_ids = Database::getStoredVideoIDs();

    echo 'used video ids:';
    var_dump(self::$used_video_ids);
    return self::catchAndLoopThroughVideos($keyword);

  }

  static private function catchAndLoopThroughImages($keyword){

    // loop from 1 to $maximum_page_iterations (10)

    for($i=1; $i <= self::$maximum_page_iterations; $i++) {
      echo 'page: ' . $i;
      // get images by keyword and page
      $images = self::getImagesByKeyword( $keyword, $i );
      echo 'images received';
       if( $images ){
         echo 'if $images';
         $validate_image_result = self::getValidImage( $images, self::$used_image_ids );

         if($validate_image_result){
           echo 'image valid';
           return $validate_image_result;
         }
         else{echo 'image invalid';}
       }

    }
  }

  static private function catchAndLoopThroughVideos($keyword){

    // loop from 1 to $maximum_page_iterations (10)

    for($i=1; $i <= self::$maximum_page_iterations; $i++) {
      echo 'page: ' . $i;
      // get images by keyword and page
      $videos = self::getVideosByKeyword( $keyword, $i );
      echo 'videos received';
       if( $videos ){
         echo 'if $images';
         $validate_video_result = self::getValidVideo( $videos, self::$used_video_ids );

         if($validate_video_result){
           echo 'Video valid';
           return $validate_video_result;
         }
         else{echo 'Video invalid';}
       }

    }
  }


  static private function getImagesByKeyword( string $keyword, $page = 1 ){
    self::$keyword = $keyword;
    echo 'getImagesByKeyword ';
    $result = \Crew\Unsplash\Search::photos( self::$keyword, $page, 30 );
    $result = $result->getResults();
    $images = array();
    foreach ($result as $image) {
      $images[] = self::getObjectFromImageArray($image);
    }
    return $images;
  }

  static public function getVideosByKeyword( string $keyword, $page = 1 ){
    self::$keyword = $keyword;
    echo 'getVideosByKeyword (Pixabay) ';
    $result = self::$pixabayClient->getVideos( ['q' => $keyword, 'page' => $page] );

    if( ! is_object($result) ) die( 'invalid pixabay Client response ' . print_r( $result, true) );

    if( ! is_array( $result->hits ) || count( $result->hits ) == 0 ) die( 'no videos found ' . print_r( $result->hits, true) );

    $videos = array();
    foreach ($result->hits as $video) {
      $videos[] = self::getObjectFromVideoArray($video);
    }
    return $videos;
  }

  static private function getObjectFromImageArray( array $raw_image ){
    $image = new Photo();
    $image->id          =   self::$source_id . '_' . $raw_image['id'];
    $image->original_id =   $raw_image['id'];
    $image->image_url   =   $raw_image['urls']['raw'];
    $image->source_name =   self::$source_name;
    $image->date        =   time();
    $image->data        =   $raw_image;
    $image->keyword     =   self::$keyword;
    $image->description =   $raw_image['description'];
    return $image;
  }

  static private function getObjectFromVideoArray( $raw_video ){
    // var_dump($raw_video);
    $video = new Video();
    $video->id            =   self::$source_id . '_' . $raw_video->picture_id;
    $video->original_id   =   $raw_video->picture_id;
    $video->source_name   =   self::$source_name;
    $video->date          =   time();
    $video->data          =   $raw_video;
    $video->video_url     =   $raw_video->videos->large->url;
    $video->keyword       =   self::$keyword;
    $video->tags          =   explode( ', ', $raw_video->tags );
    return $video;
  }

  static private function getValidImage( $images, $used_image_ids ){
    foreach( $images as $image ){
      if( ! in_array( $image->id, $used_image_ids ) ){
        return $image;
      }
    }
    return false;
  }

  static private function getValidVideo( $videos, $used_video_ids ){
    foreach( $videos as $video ){
      if( ! in_array( $video->id, $used_video_ids ) ){
        return $video;
      }
    }
    return false;
  }

}
