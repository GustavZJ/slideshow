<?php
session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] == 'uploader') {
    header("Location: /upload/index.php");
} else if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /index.html");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin</title>
    <meta name="Admin" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/src/scss/main.css">
	<link rel="icon" type="image/x-icon" href="/src/pictures/favicon.ico">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
    <script type="module" src="/src/js/deleteImage.js"></script>
</head>
<body>
    <form id="deleteForm" method="get">
        <button id="deleteBtn" class="btnWhite" type="submit" disabled="true">Slet</button>
        <button id="deleteAllBtn" class="btnRed" type="button">Slet alt</button>
        <p id="deletePreviewText">Ingen billeder i systemet</p>
        <div id="imagePreviewCont"></div>
    </form>
    
    <script src="/src/js/topbar.js"></script>
    <script type="module" src="/src/js/loadImages.js"></script>
</body>
</html>