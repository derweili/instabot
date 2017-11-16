<?php
require './vendor/autoload.php';
require './config.php';
session_start();


    \Crew\Unsplash\HttpClient::init([
        'applicationId'	=> UNSPLASH_APPLICATION_ID,
        'secret'		=> UNSPLASH_SECRET,
        'callbackUrl'	=> UNSPLASH_CALLBACK_URL,
        'utmSource' => UNSPLASH_UTM_SOURCE
    ]);

    try {
        $token = \Crew\Unsplash\HttpClient::$connection->generateToken(UNSPLASH_AUTH_CODE);
    } catch (Exception $e) {
        print("Failed to generate access token: {$e->getMessage()}");
        exit;
    }

    // Store the access token, use this for future requests
    $_SESSION['token'] = $token;
    echo 'token <br>';
    var_dump( $token );

// Send requests to Unsplash
\Crew\Unsplash\HttpClient::init([
    'applicationId'	=> UNSPLASH_APPLICATION_ID,
    'secret'		=> UNSPLASH_SECRET,
    'callbackUrl'	=> UNSPLASH_CALLBACK_URL,
    'utmSource' => UNSPLASH_UTM_SOURCE
], [
    'access_token' => $_SESSION['token']->getToken(),
    'expires_in' => 30000,
    'refresh_token' => $_SESSION['token']->getRefreshToken()
]);

$httpClient = new \Crew\Unsplash\HttpClient();
$owner = $httpClient::$connection->getResourceOwner();

print("Hello {$owner->getName()}, you have authenticated successfully");
