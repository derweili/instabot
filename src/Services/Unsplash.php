<?php

namespace Derweili\Instabot\Services;
use Derweili\Instabot\Models\Photo;
use Derweili\Instabot\Services\Database;

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

    // get stored images from database service
    $used_image_ids = Database::getStoredImageIDs();

    if( self::$images ){
      return self::getValidImage( $used_image_ids );
    }
  }


  static private function getImagesByKeyword( string $keyword, $page = 1 ){
    self::$keyword = $keyword;
    $result = \Crew\Unsplash\Search::photos( $keyword, $page, 30 );
    $result = $result->getResults();
    $images = array();
    foreach ($result as $image) {
      $images[] = self::getObjectFromImageArray($image);
    }
    self::$images = $images;
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

  static private function getValidImage( $used_image_ids ){
    foreach(self::$images as $image){
      if( ! in_array( $image->id, $used_image_ids ) ){
        return $image;
      }
    }
  }

}
