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
  static public $video_path = 'videos';
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


  static public function store_video( $video ){
    return self::$database->getReference( self::$video_path . '/' . $video->id )
    ->set( $video );
  }

  static public function getStoredImageIDs(){

    $reference = self::$database->getReference('');
    $value = $reference->getValue();
    if( ! array_key_exists( self::$image_path, $value ) ) return [];

    return self::$database->getReference( self::$image_path )->getChildKeys();
  }

  static public function getStoredVideoIDs(){

    $reference = self::$database->getReference('');
    $value = $reference->getValue();
    if( ! array_key_exists( self::$video_path, $value ) ) return [];

    $current_database = $database->getReference('');
      $stored_videos = self::$database->getReference( self::$video_path )->getChildKeys();


    return $stored_videos;
  }

  static public function store_post( $post, $image, $topics){
    self::$database->getReference( self::$instagram_post_path . '/' . $post->id . '/post_data' )
    ->set( $post );
    self::$database->getReference( self::$instagram_post_path . '/' . $post->id . '/image_data' )
    ->set( $image );
    self::$database->getReference( self::$instagram_post_path . '/' . $post->id . '/topics' )
    ->set( $topics );
  }


}
