<?php
require './../vendor/autoload.php';
require './../config/config.php';

use Derweili\Instabot\Services\Unsplash;
use Derweili\Instabot\Services\Database;


echo '<pre>';

// setup unsplash credentials
Database::setup(FIREBASE_CONFIG_FILE_PATH);



$return = Database::getStoredImageIDs();


var_dump($return);
