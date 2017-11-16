<?php
namespace Derweili\Instabot\Services;
use \Kreait\Firebase\Factory;
use \Kreait\Firebase\ServiceAccount;

/**
 * Service for database connection
 */
class Database
{

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
    return self::$database->getReference('images/' . $image->id )
    ->set( $image );
  }


}
