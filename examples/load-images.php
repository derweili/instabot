<?php
require './../vendor/autoload.php';
require './../config/config.php';


use Derweili\Instabot\Services\Unsplash;


echo '<pre>';
Unsplash::setup(UNSPLASH_APPLICATION_ID, UNSPLASH_UTM_SOURCE);
$image = Unsplash::searchByKeyword('love');

var_dump($image);
