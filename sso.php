<?php
session_start();
require 'vendor/autoload.php';

$client_id = '3OFGXV0edTTCWAkhAITRZLYApUHRuB7m';
$client_secret = 'bGiU_nsXs6NESlYkq_-kX0kIU1rqf_Lie-X2WwNdBCu6_slRSNm5XJkgdM8ewnu_';
$redirect_uri = 'http://localhost:3000/callback.php';
$okta_url = 'https://dev-ok5mh56vwtq1j2qe.us.auth0.com';

if (!isset($_GET['code'])) {
    exit('Authorization code not received');
}

$token_url = $okta_url . '/oauth2/default/v1/token';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $token_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'grant_type' => 'authorization_code',
    'code' => $_GET['code'],
    'redirect_uri' => $redirect_uri,
    'client_id' => $client_id,
    'client_secret' => $client_secret
]));

$response = curl_exec($ch);
curl_close($ch);

$token = json_decode($response, true);

if (isset($token['access_token'])) {
    $_SESSION['user'] = $token;
    header('Location: index.php');
    exit();
} else {
    exit('Error fetching access token');
}


// $event = $this->exampleHooks['onLoginRoute'] ?? null;

// if (null === $event || null === $event($router)) {
//     // Redirect to Auth0's Universal Login page.
//     $router->redirect($this->sdk->login($router->getUri('/callback', '')));
// }