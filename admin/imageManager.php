<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin</title>
    <meta name="Admin" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/src/scss/main.css">
	<link rel="icon" type="image/x-icon" href="/favicon.ico">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
    <script type="module" src="/src/js/deleteImage.js"></script>
</head>

<?php
session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] == 'uploader') {
    header("Location: /landing.php");
}

else if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /index.html");
}
?>

    <body>
    <!-- Placed at top since otherwise it might take too long to appear, while it's waiting for images to load -->
    <!-- This can be improved later -->
    <script src="/src/js/topbar.js"></script>


        <form id="deleteForm" method="get">
            <button id="deleteBtn" class="btnWhite" type="submit" disabled="true">Slet</button>
            <button id="deleteAllBtn" class="btnRed" type="button">Slet alt</button>
            <p id="deletePreviewText">Ingen billeder i systemet</p>
            <div id="imagePreviewCont">
            <?php
                // Load images from rpi, and display them
                $images = scandir('../uploads');
                foreach($images as $image) {
                    $fullImage = '../uploads/'.$image;
                    if (is_file($fullImage)) {
                        // URL encode the file path for displaying in the HTML
                        $encodedImage = str_replace('?', '%3F', $image);
                        $fullImage = '../uploads/' . $encodedImage;
                    
                        echo '<div class="imageCont elePointerIcon" onclick="checkboxThruDiv(this);">';
                        echo '  <img class="previewImage" src="'.$fullImage.'">';
                        echo '  <input type="checkbox" name="files[]" value="'.htmlspecialchars($image).'" onclick="event.stopPropagation();">';
                        echo '</div>';
                    }
                }
            ?>

            </div>
        </form>

        <!-- This has to be in a seperate script, otherwise, the import module will break it -->
        <script>
            // Function to allow clicking on image to check checkbox
            function checkboxThruDiv(target) {
                if (target.children[1].checked) {
                    target.children[1].checked = false;
                }
                else {
                    target.children[1].checked = true;
                    document.getElementById('deleteBtn').removeAttribute('disabled');
                }
            }
        </script>
    </body>
</html>