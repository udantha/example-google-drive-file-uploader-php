<?php
session_start();

//Initialization script
include_once __DIR__ . '/vendor/autoload.php';

DEFINE('GOOGLE_CREDENTIALS_FILE', 'client_secret.json');
DEFINE('REDIRECT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/index.php');
DEFINE('GOOGLE_SCOPE', 'https://www.googleapis.com/auth/drive');

/**
 * Set up Google SDK
 */
$client = new Google_Client();
$client->setAuthConfig(GOOGLE_CREDENTIALS_FILE);
$client->setRedirectUri(REDIRECT_URL);
$client->addScope(GOOGLE_SCOPE);

/**
 * Utilities
 */

// add "?logout" to the URL to remove a token from the session
if (isset($_REQUEST['logout'])) {
    unset($_SESSION['upload_token']);
}

//save recevied token and redirect
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    // store in the session also
    $_SESSION['upload_token'] = $token;

    // redirect back to the example
    header('Location: ' . filter_var(REDIRECT_URL, FILTER_SANITIZE_URL));
}