import { messageFade } from '/src/js/errorMessage.js';
import { disableBtns } from '/src/js/deleteImage.js';

jQuery(document).ready(function ($) {
    $.ajax({
        type: 'POST',
        url: '/src/php/loadImages.php',
        success: function(response) {
            for (const file of response) {
                // Hide delete btn if no images present
                if (response) {
                    document.getElementById('deleteBtn').style.display = 'inline-block';
                    document.getElementById('deleteAllBtn').style.display = 'inline-block';
                    document.getElementById('deletePreviewText').style.display = 'none';
                }

                const imageCont = document.createElement('div');
                imageCont.className = 'imageCont elePointerIcon';
                imageCont.addEventListener('click', (event) => {
                    console.log(event, event.target);
                    if (event.target.children[1].checked) {
                        event.target.children[1].checked = false;
                    } else {
                        event.target.children[1].checked = true;
                        document.getElementById('deleteBtn').removeAttribute('disabled');
                    }
                });

                const img = new Image();
                img.className = 'previewImage';
                img.src = file;
                imageCont.appendChild(img);
                
                const checkbox = document.createElement('input');
                checkbox.name = 'files[]';
                checkbox.value = file;
                checkbox.setAttribute('type', 'checkbox');
                checkbox.addEventListener('click', (event) => {event.stopPropagation();disableBtns()});
                imageCont.appendChild(checkbox);

                $('#imagePreviewCont').append(imageCont);
            }
        },
        error: function() {
            messageFade('error', 'Noget gik galt med at loade billeder, prøv at genindlæse siden.');
        }
    })
});