<?php

require dirname( dirname( __FILE__ ) ) . '/vendor/autoload.php';
require dirname( dirname( __FILE__ ) ) . '/config/config.php';

$instagram = new Andreyco\Instagram\Client(array(
  'apiKey'      => INSTAGRAM_API_KEY,
  'apiSecret'   => INSTAGRAM_API_SECRET,
  'apiCallback' => UNSPLASH_AUTH_CODE,
  'scope'       => array('basic','comments','follower_list','likes','public_content','relationships'),
));

echo "<a href='{$instagram->getLoginUrl()}'>Login with Instagram</a>";

die();
    // Generate and redirect to login URL.
    $url = Instagram::getLoginUrl();

    // After allowing to access your profile, grab authorization *code* when redirected back to your page.
    $code = $_GET['code'];
    $data = Instagram::getOAuthToken($code);

    // Now, you have access to authentication token and user profile
    echo 'Your username is: ' . $data->user->username;
    echo 'Your access token is: ' . $data->access_token;
