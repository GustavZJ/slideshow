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

        <form id="deleteForm" method="get">
            <div id="imagePreviewCont">
                <?php
                    // Load images from rpi, and display them
                    $images = scandir('../uploads');
                    foreach($images as $image) {
                        if (is_file('../uploads/'.$image)) {
                            echo '<div class="imageCont elePointerIcon" onclick="checkboxThruDiv(this)">';
                            echo '<img class="previewImage" src="../uploads/'.$image.'">';
                            echo '<input type="checkbox" name="files[]" value="'.$image.'" onclick="stopPropagation(event)">';
                            echo '</div>';
                        }
                    }
                ?>
            </div>
            <button type="submit" value="true">Slet</button>
        </form>

        <script>
            // Function to allow clicking on image to check checkbox
            function checkboxThruDiv(target) {
                if (target.children[1].checked) {
                    target.children[1].checked = false;
                }
                else {
                    target.children[1].checked = true;
                }
            }

            // Function to prevent checkbox from being checked and unchecked immediatly, if user clicks on checkbox
            function stopPropagation(event) {
                event.stopPropagation();
            }

            // Function to run php script in background
            jQuery(document).ready(function ($) {
                $("#deleteForm").submit(function (event) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete.php',
                        data: $(this).serialize(),
                        success: function () {
                            // Reload page to remove image preview
                            location.reload();
                            // Uncheck checkboxes, since sometimes checkboxes will randomly be checked after delete
                            $('input[type="checkbox"]').prop("checked", false);
                        }
                    });
                    // Prevent default action of going to php page
                    event.preventDefault();
                });
            });
        </script>
    </body>
</html>