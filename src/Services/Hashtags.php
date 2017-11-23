<?php

namespace Derweili\Instabot\Services;
use Derweili\Instabot\Services\Instagram;
use Derweili\Instabot\Models\Hashtag;


/**
 *
 */
class Hashtags
{

  static public $number_of_hashtags = 20;

  static public function get_popular_hashtags_by_search_terms( array $search_terms = [] ){
    // search hashtags by keywords (array)
    $hashtags = self::search_hashtags_by_search_terms($search_terms);

    // sort hashtags by popularity
    $sorted_hashtags = self::sort_hashtags($hashtags);

    // only use most popular hashtags
    $new_hashtags = self::stripUnpopularHashtags($sorted_hashtags);

    // re-shuffle most popular hashtags;
    return self::shuffle_hashtags( $new_hashtags );
  }

  static private function search_hashtags_by_search_terms($search_terms){
    $all_hashtags = [];

    foreach ( $search_terms as $search ) {
      $search_result = Instagram::search_hashtags( $search );
      $all_hashtags = array_merge($all_hashtags, $search_result);
    }

    return $all_hashtags;
  }


  static private function sort_hashtags( $hashtags ){
    usort($hashtags, function($a, $b){
     return $a->media_count <= $b->media_count;
    });

    return $hashtags;
  }

  static private function stripUnpopularHashtags($hashtags, $number_of_hashtags = null){
    if(null == $number_of_hashtags) $number_of_hashtags = self::$number_of_hashtags;
    return array_slice($hashtags, 0, $number_of_hashtags, true);
  }

  static private function shuffle_hashtags($hashtags){
    shuffle($hashtags);
    return $hashtags;
  }

}
