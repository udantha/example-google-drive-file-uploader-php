<?php

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
