<?php
session_start();
if (!isset($_SESSION['role']) || !($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'uploader')) {
    header("Location: /index.html");
}
?>

<!DOCTYPE html>
<html lang="dk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billedeupload</title>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="src/scss/main.css">
    <link rel="icon" type="image/x-icon" href="/src/pictures/favicon.ico">
</head>
<body>
    <div id="navImgWrapper">
        <a class="imageBtn" href="/admin/index.php">
            <div class="image-container">
                <img src="/src/pictures/admin.png" alt="Adminside">
                <span class="overlay-text">Adminside</span>
            </div>
        </a>
        <a class="imageBtn" href="/upload/index.php">
            <div class="image-container">
                <img src="/src/pictures/upload.png" alt="Uploadside">
                <span class="overlay-text">Uploadside</span>
            </div>
        </a>
    </div>


    <script src="/src/js/topbar.js"></script>
</body>
</html>