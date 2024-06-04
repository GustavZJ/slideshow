<!DOCTYPE html>
<html lang="dk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billedeupload</title>
    <link rel="stylesheet" href="src/scss/main.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="icon" type="image/x-icon" href="/src/pictures/favicon.ico">
</head>

<?php
session_start();

if (!isset($_SESSION['role']) || !( $_SESSION['role'] == 'admin' || $_SESSION['role'] == 'uploader') ) {
    header("Location: ../index.html");
}
?>

<body>
    <a class="labelBtn imageBtn" href="/admin/index.html">
        <div class="image-container">
            <img src="/src/pictures/admin.png" alt="Adminside">
            <span class="overlay-text">Adminside</span>
        </div>
    </a>
    <a class="labelBtn imageBtn" href="/upload/index.html">
        <div class="image-container">
            <img src="/src/pictures/upload.png" alt="Uploadside">
            <span class="overlay-text">Uploadside</span>
        </div>
    </a>
    
    <script src="/src/js/topbar.js"></script>
</body>
</html>