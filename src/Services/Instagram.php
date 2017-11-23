<?php

namespace Derweili\Instabot\Services;
use Derweili\Instabot\Models\Photo;
use Derweili\Instabot\Models\Hashtag;
use InstagramAPI\Instagram as PrivateInstagramAPI;
use Andreyco\Instagram\Client as PublicInstagramAPI;


/**
 *
 */
class Instagram
{
  static public $video_width = 1080;

  static public $video_height = 1080;

  // used as service object for the official instagram api
  static public $instagram_official;

  static private $ig;
  static private $debug = true;
  static private $truncatedDebug = false;

  static public function setup( $username, $password ){
    self::$ig = new PrivateInstagramAPI(self::$debug, self::$truncatedDebug);
    self::login($username, $password);
  }

  static public function setup_official_api( string $instagram_api_key, string $instagram_access_token ){
    self::$instagram_official = new \Andreyco\Instagram\Client($instagram_api_key);
    self::$instagram_official->setAccessToken($instagram_access_token);
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


  static public function postVideo( $imagePath, $captionText ){
    echo '<h1>post video</h1>';
    try {
        $return = self::$ig->timeline->uploadVideo( $imagePath, [ 'caption' => $captionText ] );
    } catch (\Exception $e) {
        echo 'Something went wrong: '.$e->getMessage()."\n";
    }
    return $return;
  }

  static public function postStoryImage( $imagePath, $captionText, $hashtags = array() ){
    // Hashtag content (currently empty)
    // [
    //     // Note that you can add more than one hashtag in this array.
    //     [
    //         'tag_name'         => 'test', // Hashtag WITHOUT the '#'! NOTE: This hashtag MUST appear in the caption.
    //         'x'                => 0.5, // Range: 0.0 - 1.0. Note that x = 0.5 and y = 0.5 is center of screen.
    //         'y'                => 0.5, // Also note that X/Y is setting the position of the CENTER of the clickable area.
    //         'width'            => 0.24305555, // Clickable area size, as percentage of image size: 0.0 - 1.0
    //         'height'           => 0.07347973, // ...
    //         'rotation'         => 0.0,
    //         'is_sticker'       => false, // Don't change this value.
    //         'use_custom_title' => false, // Don't change this value.
    //     ],
    //     // ...
    // ]

    $metadata = [
        'hashtags' => [],
        'caption' => $captionText,
    ];

    try {
        $return = self::$ig->story->uploadPhoto($imagePath, $metadata);
        // NOTE: Providing metadata for story uploads is OPTIONAL. If you just want
        // to upload the story without hashtags, just do the following instead:
        // $ig->story->uploadPhoto($photoFilename);
    } catch (\Exception $e) {
        echo 'Something went wrong: '.$e->getMessage()."\n";
    }

    return $return;
  }

  /*
   * Search for Hashtags via official Instagram API
   */
  static public function search_hashtags( string $search = '' ){
    $results = self::$instagram_official->searchTags($search);
    $return = [];
    // var_dump($results);

    // loop through results an transform into Hashtag Model
    foreach ( $results->data as $result ) {
      $new_hashtag = new Hashtags();
      $new_hashtag->name = $result->name;
      $new_hashtag->media_count = $result->media_count;
      $return[] = $new_hashtag;
    }
    return $return;
  }

}
