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
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
    </head>
    <body>
        <a class="labelBtn btnWhite" href="/upload/index.html">Til upload-side</a>
        <div id="imageUploadCont">
            <div id="imagePreviewCont">
                <form id="deleteForm" method="get">
                    <?php
                        $images = scandir('../uploads');
                        foreach($images as $image) {
                            if (is_file('../uploads/'.$image)) {
                                echo '<div class="imageCont">';
                                echo '<img class="previewImage" src="../uploads/'.$image.'">';
                                echo '<input type="checkbox" name="files[]" value="'.$image.'">';
                                echo '</div>';
                            }
                        }
                    ?>
                    <button type="submit" value="true">Slet</button>
                </form>
            </div>
        </div>

        <script>
            jQuery(document).ready(function ($) {
                $("#deleteForm").submit(function (event) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete.php',
                        data: $(this).serialize(),
                        success: function () {
                            location.reload();
                            $('input[type="checkbox"]').prop("checked", false);
                        }
                    });
                    event.preventDefault();
                });
            });
        </script>
    </body>
</html>