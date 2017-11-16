<?php
require './../vendor/autoload.php';
require './../config/config.php';

session_start();


\Crew\Unsplash\HttpClient::init([
    'applicationId'	=> UNSPLASH_APPLICATION_ID,
    'utmSource' => UNSPLASH_UTM_SOURCE
]);

$photos = \Crew\Unsplash\Search::photos('Love', 1, 30);



echo '<pre>';
var_dump($photos->getResults());
