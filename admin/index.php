<!DOCTYPE html>
<html lang="dk">
<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/src/scss/main.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="/src/pictures/favicon.ico">
</head>

<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.html");
    exit();
}
?>

<body>
    <a class="labelBtn imageBtn" href="/admin/imageManager.php">
        <div class="image-container">
            <img src="/src/pictures/imageManager.png" alt="Billedemanager">
            <span class="overlay-text">Billedemanager</span>
        </div>
    </a>

    <a class="labelBtn imageBtn" href="/admin/config.html">
        <div class="image-container">
            <img src="/src/pictures/config.png" alt="Configside">
            <span class="overlay-text">Config</span>
        </div>
    </a>

    <script src="/src/js/topbar.js"></script>
</body>

</html>