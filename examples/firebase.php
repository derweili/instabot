<?php
require './../vendor/autoload.php';
require  dirname( dirname( __FILE__ ) ) . '/config/config.php';
session_start();

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
echo '<pre>';
$serviceAccount = ServiceAccount::fromJsonFile( FIREBASE_CONFIG_FILE_PATH );
$firebase = (new Factory)
    ->withServiceAccount( $serviceAccount )
    ->create();
$database = $firebase->getDatabase();

echo '<h2>Reference</h2>';
$reference = $database->getReference('');
$value = $reference->getValue();

if( array_key_exists( 'videos', $value ) ) echo 'exists';

echo '<h2>Snapshot</h2>';
$snapshot = $reference->getSnapshot();
// var_dump($snapshot->getValue());
