<?php

namespace Derweili\Instabot\Services;
use Derweili\Instabot\Models\Photo;

/**
 * Unplass API Service
 */
class Unsplash
{

  static public $source_id = 'unsplash';
  static public $source_name = 'Unsplash';
  static public $keyword;
  static public $images;

  /*
   * @param array $result
   */
  static private $result;

  static public function setup( string $application_id, string $utm_source )
  {
    \Crew\Unsplash\HttpClient::init([
        'applicationId'	=> $application_id,
        'utmSource' => $utm_source
    ]);
  }

  static public function searchByKeyword( string $keyword, $used_image_ids = array() ){
    self::getImagesByKeyword( $keyword );
    if( self::$result ){
      return self::validate_images( $used_image_ids );
    }
  }


  static private function getImagesByKeyword( string $keyword, $page = 1 ){
    self::$keyword = $keyword;
    $result = \Crew\Unsplash\Search::photos( $keyword, $page, 30 );
    $images = array();
    foreach ($result as $image) {
      $images[] = self::getObjectFromImageArray($image);
    }
    self::$images = $images;
  }

  static private function getObjectFromImageArray( array $image ){
    $image = new Photo();
    $image->id          =   self::$source_id . '_' . $image['id'];
    $image->original_id =   $image['id'];
    $image->image_url   =   $image['urls']['raw'];
    $image->source_name =   self::$source_name;
    $image->date        =   time();
    $image->data        =   $image;
    $image->keyword     =   self::$keyword;
    $image->description =   $image['description'];
    return $image;
  }

  static private function getValidImage( $used_image_ids ){
    foreach(self::$images as $image){
      if( ! in_array( $image->id, $used_image_ids ) ){
        return $image;
      }
    }
  }

}
