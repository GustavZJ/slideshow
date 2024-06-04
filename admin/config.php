<!DOCTYPE html>
<html lang="dk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfig</title>
    <link rel="stylesheet" href="/src/scss/main.css">
    <link rel="icon" type="image/x-icon" href="/src/pictures/favicon.ico">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
    <script type="module" src="/src/js/configEdit.js"></script>
</head>
<?php
session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] == 'uploader') {
    header("Location: ../landing.php");
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.html");
}
?>
<body>
    <form id="configForm" method="get" enctype="multipart/form-data">
        <div id="configCont">

            <label for="timedelay">Tid imellem billeder (Sekunder)</label>
            <input type="text" name="timedelay" id="timedelay" class="configInputs textInputs">

            <label for="maxsize">Maximal størrelse for et enkelt billede (mB)</label>
            <input type="text" name="maxsize" id="upload_max_filesize" class="configInputs textInputs">

            <label for="maxamount">Maximal mængde af filer, som kan uploads samtidigt</label>
            <input type="text" name="maxamount" id="max_file_uploads" class="configInputs textInputs">

            <label for="removeimagetoggle">Slå fjernelse af billeder til / fra</label>
            <input type="checkbox" name="autoremove" id="autoremove" class="configInputs">

            <div id="removeImageCont">
                <label for="removeimageamount">Hvor mange billeder skal der være, før de må blive fjernet</label>
                <input class="configInputs textInputs removeImageInputs" type="text" name="autoremoveamount" id="autoremoveamount"
                    disabled="true">

                <label for="removeimagetime">Hvor længe skal et billede blive, før de bliver fjernet</label>
                <div id="selectCont">
                    <!-- Add the value for option to post -->
                    <input class="configInputs textInputs removeImageInputs" type="text" name="autoremovetimepost"
                        id="autoremovetimepost" disabled="true">
                    <select class="configInputs removeImageInputs" name="autoremovetimeoption" id="autoremovetimeoption"
                        disabled="true">
                        <option value="days">dag(e)</option>
                        <option value="months">måned(er)</option>
                        <option value="years">år</option>
                    </select>
                </div>
            </div>
        </div>
        <button id="confirmBtn" class="btnWhite" type="submit" disabled="true">Opdater konfig</button>
    </form>

    <script src="/src/js/topbar.js"></script>
</body>
</html>