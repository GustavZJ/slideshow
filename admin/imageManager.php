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
            <p id="deletePreviewText">Ingen billeder i systemet</p>
            <div id="imagePreviewCont">
                <?php
                    // Load images from rpi, and display them
                    $images = scandir('../uploads');
                    foreach($images as $image) {
                        if (is_file('../uploads/'.$image)) {
                            echo '<div class="imageCont elePointerIcon" onclick="checkboxThruDiv(this) disableBtns()">';
                            echo '  <img class="previewImage" src="../uploads/'.$image.'">';
                            echo '  <input type="checkbox" name="files[]" value="'.$image.'" onclick="event.stopPropagation() disableBtns()">';
                            echo '</div>';
                        }
                    }
                ?>
            </div>
            <button id="deleteBtn" class="btnWhite" type="submit" disabled="true">Slet</button>
            <button id="deleteAllBtn" class="btnRed" type="button">Slet alt</button>
        </form>

        <script type="module">
            import { confirmAction } from '/src/js/confirmAction.js'
            import { messageFade } from '/src/js/errorMessage.js'

            // Hide delete btn if no images present
            if (document.getElementById('imagePreviewCont').childElementCount == 0) {
                document.getElementById('deleteBtn').style.display = 'none';
                document.getElementById('deleteAllBtn').style.display = 'none';
            }
            else {
                document.getElementById('deletePreviewText').style.display = 'none';
            }

            function disableBtns() {
                document.getElementById('deleteBtn').setAttribute('disabled', true);
                for (const child of document.getElementById('imagePreviewCont').children) {
                    if (child.children[1].checked) {
                        document.getElementById('deleteBtn').removeAttribute('disabled');
                        break;
                    }
                }
            }

            document.getElementById('deleteAllBtn').onclick = () => {
                confirmAction('slet alle billeder')
                    .then (value => {
                        if (value) {
                            $('input[type="checkbox"]').prop('checked', true);
                        }
                    });
                }

            // Function to run php script in background
            jQuery(document).ready(function ($) {
                // Uncheck checkboxes, since sometimes checkboxes will randomly be checked after delete
                $('input[type="checkbox"]').prop('checked', false);
                document.getElementById('deleteBtn').setAttribute('disabled', true);
                
                const images = document.getElementsByClassName('imageCont');
                const errorList = [];
                let deleteCount = 0;
                let errMsg = ''

                // Handle delete action
                $("#deleteForm").submit(function (event) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete.php',
                        data: $(this).serialize(),
                        success: function (response) {
                            for (let file in response) {
                                if (response[file] === "success") {
                                    deleteCount += 1;
                                    $(`.previewImage[src='../uploads/${file}']`).closest('.imageCont').remove();
                                } else {
                                    errorList.push(file);
                                }
                            }

                            // Hide delete btn if no images present
                            if (document.getElementById('imagePreviewCont').childElementCount == 0) {
                                document.getElementById('deleteBtn').style.display = 'none';
                                document.getElementById('deleteAllBtn').style.display = 'none';
                                document.getElementById('deletePreviewText').style.display = 'block';
                            }

                            disableBtns();
                            
                            // Give succeess message
                            if (errorList.length == 0) {
                                messageFade('success', `${deleteCount} billede(r) blev fjernet`);
                            }
                            else {
                                if (deleteCount > 0) {
                                    errMsg += `${deleteCount} billede(r) blev fjernet<br>`;
                                }
                                errMsg += (`Fejl, disse billeder blev ikke fjernet:<br>
                                ${[...errorList].join('<br>')}`);
                                messageFade('error', errMsg);
                            }

                            // Reset counters, etc.
                            deleteCount = 0;
                            errMsg = '';
                            errorList.length = 0
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
                    document.getElementById('deleteBtn').removeAttribute('disabled');
                    document.getElementById('deleteAllBtn').removeAttribute('disabled');
                }
            }

            // Function to prevent checkbox from being checked and unchecked immediatly, if user clicks on checkbox
            function stopPropagation(event) {
                event.stopPropagation();
            }
        </script>
    </body>
</html>