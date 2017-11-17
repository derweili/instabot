<?php

namespace Derweili\Instabot\Models;

/**
 *
 */
class InstagramImage
{

  public $upload_id;

  public $code;

  public $id;

  public $pk;

  public $timestamp;

  public $image_url;

  public $thumbnail_url;

  public $description;

  public $data;




  saveFromInstagramResponse( $response_object ){
    $this->upload_id = $response_object->upload_id;
    $this->code = $response_object->media->code;
    $this->id = $response_object->media->id;
    $this->pk = $response_object->media->pk;
    $this->timestamp = $response_object->media->taken_at;
    $this->image_url = $response_object->media->image_versions2->candidates[0];
    $this->thumbnail_url = $response_object->media->image_versions2->candidates[1];
    $this->description = $response_object->media->caption->text;
  }


}
