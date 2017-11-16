<?php

namespace \Derweili\Instabot\;

use GuzzleHttp\Client;


/**
 * Images Loader
 */
class Images
{

  public static function initUnsplash( string $unsplash_application_id, string $unsplash_application_source ){
    \Crew\Unsplash\HttpClient::init([
        'applicationId'	=> $unsplash_application_id,
        'utmSource' => $unsplash_application_source
    ]);
  }

  public static function searchByKeyword( string $keyword ){
    self::searchUnsplash($keyword);
  }


  function searchUnsplash(){
    $photos = \Crew\Unsplash\Search::photos('Love', 1, 30);
  }

}
