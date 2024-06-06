<!DOCTYPE html>
<html lang="dk">

<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
    <link rel="stylesheet" href="/src/scss/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="/src/js/logout.js"></script>
    <link rel="icon" type="image/x-icon" href="/src/pictures/favicon.ico">
</head>

<?php
session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] == 'uploader') {
    header("Location: /landing.php");
} else if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /index.html");
}
?>

<body>
    <div id="navImgWrapper">
        <a class="imageBtn" href="/admin/imageManager.php">
            <div class="image-container">
                <img src="/src/pictures/imageManager.png" alt="Billedemanager">
                <span class="overlay-text">Billedemanager</span>
            </div>
        </a>

        <a class="imageBtn" href="/admin/config.php">
            <div class="image-container">
                <img src="/src/pictures/config.png" alt="Configside">
                <span class="overlay-text">Config</span>
            </div>
        </a>
    </div>
    <div id="qrWrapper">
        <img id="qr" src="/src/pictures/qrcode.png">
        <p>Dette er en qr-kode til dette website. Den kan printes ud!</p>
    </div>

    <script src="/src/js/topbar.js"></script>
</body>

</html>