<?php

namespace Derweili\Instabot\Services;
use Derweili\Instabot\Models\Photo;
use InstagramAPI\Instagram as PrivateInstagramAPI;


/**
 *
 */
class Instagram
{
  static private $ig;
  static private $debug = true;
  static private $truncatedDebug = false;

  static public function setup( $username, $password ){
    self::$ig = new PrivateInstagramAPI(self::$debug, self::$truncatedDebug);
    self::login($username, $password);
  }

  static private function login( $username, $password ){
    try {
        self::$ig->login($username, $password);
    } catch (\Exception $e) {
        echo 'Something went wrong: '.$e->getMessage()."\n";
        exit(0);
    }
  }

  static public function postImage( $imagePath, $captionText ){
    try {
        $return = self::$ig->timeline->uploadPhoto($imagePath, ['caption' => $captionText]);
    } catch (\Exception $e) {
        echo 'Something went wrong: '.$e->getMessage()."\n";
    }
    return $return;
  }


}
