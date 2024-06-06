import { messageFade } from '/src/js/errorMessage.js';

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
                imageCont.setAttribute('onclick', checkboxThruDiv(this));

                const img = new Image();
                img.className = 'previewImage';
                img.src = file;
                imageCont.appendChild(img);
                
                const checkbox = document.createElement('input');
                checkbox.name = 'files[]';
                checkbox.value = file;
                checkbox.setAttribute('type', 'checkbox');
                checkbox.setAttribute('onclick', (event) => event.stopPropagation());
                imageCont.appendChild(checkbox);

                $('#imagePreviewCont').append(imageCont);
            }
        },
        error: function() {
            messageFade('error', 'Noget gik galt med at loade billeder, prøv at genindlæse siden.');
        }
    })
});