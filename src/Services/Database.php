<?php
namespace Derweili\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

/**
 * Service for database connection
 */
class Database
{

  static public $firebase;

  static public function setup( $path_to_config_json ){
    $serviceAccount = ServiceAccount::fromJsonFile( $path_to_config_json );
    self::$firebase = (new Factory)
        ->withServiceAccount( $serviceAccount )
        ->create();
  }


  static public function store_image( $image ){
    return $database->getReference('images/' . $image->id )
    ->set( $image );
  }


}
