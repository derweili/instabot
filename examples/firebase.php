<?php
require './../vendor/autoload.php';
require './../config.php';
session_start();

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/firebase-config.json');
$firebase = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->create();

    $database = $firebase->getDatabase();
    $database->getReference('config/website')
    ->set([
       'name' => 'My Application',
       'emails' => [
           'support' => 'support@domain.tld',
           'sales' => 'sales@domain.tld',
       ],
       'website' => 'https://app.domain.tld',
      ]);

    $database->getReference('config/website/name')->set('New name');
