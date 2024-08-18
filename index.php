<?php
session_start();
require 'vendor/autoload.php';

$client_id = '3OFGXV0edTTCWAkhAITRZLYApUHRuB7m';
$redirect_uri = 'http://localhost:3000/callback.php';
$okta_url = 'https://dev-ok5mh56vwtq1j2qe.us.auth0.com';

if (!isset($_SESSION['user'])) {
    $auth_url = $okta_url . '/oauth2/default/v1/authorize?' . http_build_query([
        'client_id' => $client_id,
        'redirect_uri' => $redirect_uri,
        'response_type' => 'code',
        'scope' => 'openid profile email',
        'state' => bin2hex(random_bytes(5))
    ]);
    header('Location: ' . $auth_url);
    exit();
}
readfile('index.html');
