<?php
namespace Derweili\Instabot\Services;
use \Kreait\Firebase\Factory;
use \Kreait\Firebase\ServiceAccount;

/**
 * Service for database connection
 */
class Database
{

  static public $image_path = 'images';
  static public $instagram_post_path = 'instagram_posts';

  static public $firebase;
  static public $database;

  static public function setup( $path_to_config_json ){
    $serviceAccount = ServiceAccount::fromJsonFile( $path_to_config_json );
    self::$firebase = (new Factory)
        ->withServiceAccount( $serviceAccount )
        ->create();
    self::$database = self::$firebase->getDatabase();
  }


  static public function store_image( $image ){
    return self::$database->getReference( self::$image_path . '/' . $image->id )
    ->set( $image );
  }

  static public function getStoredImageIDs(){
    return self::$database->getReference( self::$image_path )->getChildKeys();
  }

  static public function store_post( $post, $image ){
    self::$database->getReference( self::$instagram_post_path . '/' . $post->id . '/post_data' )
    ->set( $post );
    self::$database->getReference( self::$instagram_post_path . '/' . $post->id . '/image_data' )
    ->set( $image );
  }


}
