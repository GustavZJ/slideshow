<!DOCTYPE html>
<html lang="dk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billedeupload</title>
    <link rel="stylesheet" href="/src/scss/main.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="icon" type="image/x-icon" href="/src/pictures/favicon.ico">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
    <script type="module" src="/src/js/imageManager.js"></script>
    <script type="module" src="/src/js/uploadImage.js"></script>
</head>

<?php
session_start();

if (!isset($_SESSION['role']) || !( $_SESSION['role'] == 'admin' || $_SESSION['role'] == 'uploader') ) {
    header("Location: ../index.html");
}
?>

<body>
    <div id="imageUploadCont">
        <form id="uploadForm" method="get" enctype="multipart/form-data">
            <div id="uploadImageFile">
                <input type="file" id="uploadImageInput" multiple="multiple" accept="image/*" name="files[]">
                <label for="uploadImageInput" id="uploadLabel">Klik for at uploade</label>
            </div>
            <input class="labelBtn btnWhite" type="submit" value="Upload" id="submitBtn" disabled>
            <button class="labelBtn btnRed" type="button" id="clearBtn" disabled>Ryd</button>
        </form>
        <p id="amountText">Billeder valgt: 0/x</p>
        <div id="imagePreviewCont"></div>
    </div>

    <form id="hiddenForm" method="get" enctype="multipart/form-data">
        <input type="file" id="hiddenImageInput" multiple="multiple" accept="image/*" name="hidden[]">
        <input id="hiddenSubmit" type="submit" value="Upload">
    </form>

    <script src="/src/js/topbar.js"></script>
    <script type="module" src="/src/js/errorMessage.js"></script>
</body>
</html>