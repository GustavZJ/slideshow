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
        <a class="labelBtn" href="/upload/index.html">Til upload-side</a>

        <?php
            $html = "";
            $images = scandir('../uploads');
            $html .= '<div id="imageUploadCont">';
            $html .= '<div id="uploadedImagesCont">';
            $html .= '<form id="deleteForm" method="get>';
            foreach($images as $image) {
                if (is_file('../uploads/'.$image)) {
                    $html .= '<div class="imageCont">';
                    $html .= '<img style="max-height: 15svh" class="previewImage" src="../uploads/'.$image.'">';
                    $html .= '<input type="checkbox" name="files[]" value="'.$image.'">';
                    $html .= '</div>';
                }
            }
            $html .= '<button type="submit" value="true">Slet</button>';
            $html .= '</form>';
            $html .= '</div>';
            
            echo $html;
        ?>

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