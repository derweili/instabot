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
  static private $maximum_page_iterations = 10;

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

    self::$used_image_ids = Database::getStoredImageIDs();



    if( self::$images ){
      return self::getValidImage( $used_image_ids );
    }
  }

  static private function catchAndLoopThroughImages(){

    // loop from 1 to $maximum_page_iterations (10)

    for($i=1; $i <= self::$maximum_page_iterations; $i++) {
      echo 'page: ' . $i;
      // get images by keyword and page
      $images = self::getImagesByKeyword( $keyword, $i );

       if( $images ){
         $validate_image_result = self::getValidImage( $images, $used_image_ids );

         if($validate_image_result) return $validate_image_result;
       }

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

  static private function getValidImage( $images, $used_image_ids ){
    foreach( $images as $image ){
      if( ! in_array( $image->id, $used_image_ids ) ){
        return $image;
      }
    }
    return false;
  }

}
