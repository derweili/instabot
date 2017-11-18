<?php
// ini_set('display_errors', 'off');
require '../vendor/autoload.php';
require '../config/config.php';
$instagram = new Andreyco\Instagram\Client(INSTAGRAM_API_KEY);
$instagram->setAccessToken(INSTAGRAM_API_ACCESS_TOKEN);
$result = $instagram->getUserMedia();

echo '<pre>';
var_dump($result);
