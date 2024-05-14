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
        <a class="labelBtn btnWhite" href="/admin/config.html">Til config-side</a>

        <form id="deleteForm" method="get">
            <div id="imagePreviewCont">
                <?php
                    // Load images from rpi, and display them
                    $images = scandir('../uploads');
                    foreach($images as $image) {
                        if (is_file('../uploads/'.$image)) {
                            echo '<div class="imageCont elePointerIcon" onclick="checkboxThruDiv(this)">';
                            echo '  <img class="previewImage" src="../uploads/'.$image.'">';
                            echo '  <input type="checkbox" name="files[]" value="'.$image.'" onclick="stopPropagation(event)">';
                            echo '</div>';
                        }
                    }
                ?>
            </div>
            <button id="confirmBtn" type="submit" value="true">Slet</button>
        </form>

        <script type="module">
            import {messageFade} from '/src/js/errorMessage.js'

            // Hide delete btn if no images present
            if (document.getElementById('imagePreviewCont').childElementCount == 0) {
                document.getElementById('confirmBtn').style.display = 'none';
            }

            // Function to run php script in background
            jQuery(document).ready(function ($) {
                // Uncheck checkboxes, since sometimes checkboxes will randomly be checked after delete
                $('input[type="checkbox"]').prop("checked", false);
                const images = document.getElementsByClassName('imageCont');
                const errorList = [];
                let deleteCount = 0;

                // Handle delete action
                $("#deleteForm").submit(function (event) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete.php',
                        data: $(this).serialize(),
                        success: function (response) {
                            for (let file in response) {
                                if (response[file] === "success") {
                                    // Delete successful, remove image
                                    deleteCount += 1;
                                    $(`.previewImage[src='../uploads/${file}']`).closest('.imageCont').remove();
                                } else {
                                    // Delete failed, display error message
                                    errorList.push(file);
                                }
                            }

                            // Hide delete btn if no images present
                            if (document.getElementById('imagePreviewCont').childElementCount == 0) {
                                document.getElementById('confirmBtn').style.display = 'none';
                            }
                            
                            // Give succeess message
                            if (errorList.length == 0) {
                                messageFade('success', `${deleteCount} billede(r) blev fjernet`);
                            }
                            else {
                                errMsg = (`${deleteCount} billede(r) blev fjernet
                                Fejl, disse billeder blev ikke fjernet:
                                ${[...errorList]}`);
                                messageFade('error', errMsg);
                            }
                            deleteCount = 0;
                        },
                        error: function() {
                            // Give error message
                            messageFade('error', 'Ingen billeder blev fjernet');
                        }
                    });
                    // Prevent default action of going to php page
                    event.preventDefault();
                });
            });
        </script>

        <!-- This has to be in a seperate script, otherwise, the import module will break it -->
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
        </script>
    </body>
</html>