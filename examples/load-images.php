<?php
require './../vendor/autoload.php';
require './../config/config.php';


use Derweili\Instabot\Services\Unsplash;


echo '<pre>';
Unsplash::setup(UNSPLASH_APPLICATION_ID, UNSPLASH_UTM_SOURCE);
$search = $_GET['search'] ? $_GET['search'] : 'love';
$image = Unsplash::searchByKeyword($search);

echo "<img src='{$image->image_url}' />";
