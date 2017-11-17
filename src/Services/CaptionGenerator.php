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
      $hashtags_string .= '#' . $hashtag . ' ';
    }

    return $hashtags_string;

  }

}
