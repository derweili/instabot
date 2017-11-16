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
    echo 'searchByKeyword ' . $keyword;
    self::getImagesByKeyword( $keyword );
    if( self::$result ){
      return self::validate_images( $used_image_ids );
    }
  }


  static private function getImagesByKeyword( string $keyword, $page = 1 ){
    echo 'getImagesByKeyword ' . $keyword;
    self::$keyword = $keyword;
    $result = \Crew\Unsplash\Search::photos( $keyword, $page, 30 );
    echo '<hr><h1>Result</h1>';
    $result = $result->getResults();
    var_dump($result);
    $images = array();
    foreach ($result as $image) {
      echo 'foreach ($result as $image) {';
      $images[] = self::getObjectFromImageArray($image);
    }
    echo '<hr><h1>images array</h1>';
    var_dump($images);
    self::$images = $images;
  }

  static private function getObjectFromImageArray( array $raw_image ){
    echo '<hr><h1>getObjectFromImageArray</h1>';
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
    echo '<hr><h1>getValidImage</h1>';
    var_dump($images);
    foreach(self::$images as $image){
      echo 'foreach image';
      if( ! in_array( $image->id, $used_image_ids ) ){
        return $image;
      }
    }
  }

}
