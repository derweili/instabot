<?php
require './../vendor/autoload.php';
require './../config/config.php';

use Derweili\Instabot\Services\Unsplash;
use Derweili\Instabot\Services\Database;


echo '<pre>';

// setup unsplash credentials
Database::setup(FIREBASE_CONFIG_FILE_PATH);

$image = new class {
    public $id = 'unsplash_seflsefilsef';
    public $url = 'http://google.com';
};

$return = Database::store_image($image);

var_dump($return);
