<?php
require_once('init.php');

// Set up client object if token is available
if (!empty($_SESSION['upload_token'])) {
    $client->setAccessToken($_SESSION['upload_token']);
    if ($client->isAccessTokenExpired()) {
        unset($_SESSION['upload_token']);
    }
} else {
    //get the url to retrieve token otherwise
    $authUrl = $client->createAuthUrl();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Your page title here :)</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
</head>

<body>
    <div class="container">
        <h1 class="u-full-width" style="text-align: center; margin-top: 10%">GDrive File Uploader</h1>
        <div class="row">
            <div class="one-half column" style="margin-top: 5%">
                <h4>Welcome to Google Drive file uploader</h4>
                <?php if (isset($authUrl)) : ?>
                    <p>Looks like you haven't connected Google Drive. Click to get started.</p>
                    <div class="request">
                    </div>
                <?php else : ?>
                    <form method="POST">
                        <input type="submit" value="Click here to upload two small (1MB) test files" />
                    </form>
                <?php endif ?>
            </div>
            <div class="one-half column" style="margin-top: 5%">
                <a class='login' href='<?= $authUrl ?>'><button class="button-primary">Connect to Google Drive</button></a>

            </div>
        </div>
    </div>
</body>

</html>