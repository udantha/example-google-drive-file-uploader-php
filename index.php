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

/**
 * Upload file to google drive
 */
$errorMessage = '';
if (!empty($_FILES['uploaded_file']) && $client->getAccessToken()) {

    if (file_exists($_FILES['uploaded_file']['tmp_name'])) {
        try {
            $fileName = basename($_FILES['uploaded_file']['name']);
            $filePath = $_FILES['uploaded_file']['tmp_name'];

            //start uploading to google drive
            $service = new Google_Service_Drive($client);

            $file = new Google_Service_Drive_DriveFile();
            $file->setName($fileName);
            $result2 = $service->files->create(
                $file,
                array(
                    'data' => file_get_contents($filePath),
                    'mimeType' => 'application/octet-stream',
                    'uploadType' => 'multipart'
                )
            );
        } catch (\Exception $th) {
            $errorMessage = $th->getMessage();
        }
    } else {
        $errorMessage = "There was an error uploading the file, please try again!";
    }
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
        <?php if (!empty($errorMessage)) : ?>
            <p style="color: red;"><b><?= $errorMessage ?></b></p>
        <?php endif ?>

        <?php if (isset($authUrl)) : ?>
            <div class="row">
                <div class="one-half column" style="margin-top: 5%">
                    <h4>Welcome to Google Drive file uploader</h4>
                    <p>Looks like you haven't connected Google Drive. Click to get started.</p>
                    <div class="request">
                    </div>

                </div>
                <div class="one-half column" style="margin-top: 5%">
                    <a class='login' href='<?= $authUrl ?>'><button class="button-primary">Connect to Google Drive</button></a>
                </div>
            </div>
        <?php else : ?>
            <div class="u-full-width">
                <form enctype="multipart/form-data" id="uploadform" action="" method="POST">
                    <p>Upload your file</p>
                    <input type="file" name="uploaded_file" onchange="document.getElementById('uploadform').submit()"></input><br />
                    <input type="submit" value="Upload"></input>
                </form>
            </div>
        <?php endif ?>
    </div>
</body>

</html>