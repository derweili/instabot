<?php

namespace Derweili\Instabot\Services;
use \Eventviva\ImageResize;

/**
 *
 */
class CaptionGenerator
{

  static public function generate_hashtag_string($hashtags){
    $hashtags_string = '';
    foreach ($hashtags as $hashtag) {
      if (is_object($hashtag)) {
        $hashtags_string .= '#' . $hashtag->name . ' ';
        # code...
      }else{
        $hashtags_string .= '#' . $hashtag . ' ';
      }
    }

    return $hashtags_string;

  }

}
