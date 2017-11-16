<?php
require './../vendor/autoload.php';
require './../config/config.php';

use Derweili\Instabot\Services\Unsplash;
use Derweili\Instabot\Services\Database;


echo '<pre>';

// setup unsplash credentials
Unsplash::setup(UNSPLASH_APPLICATION_ID, UNSPLASH_UTM_SOURCE);
Database::setup(FIREBASE_CONFIG_FILE_PATH);

$search = $_GET['search'] ? $_GET['search'] : 'love';


// search for image by keyword
$image = Unsplash::searchByKeyword($search);

echo "<img src='{$image->image_url}' />";

$return = Database::store_image($image);

var_dump($return);
