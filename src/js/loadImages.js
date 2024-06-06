import { messageFade } from '/src/js/errorMessage.js';

jQuery(document).ready(function ($) {
    $.ajax({
        type: 'POST',
        url: 'loadImages.php',
        success: function(response) {
            for (const file in response) {
                const imageCont = document.createElement('div');
                imageCont.className = 'imageCont elePointerIcon';
                imageCont.setAttribute('click', () => checkboxThruDiv(this));

                const img = new Image();
                img.className = 'previewImage';
                img.src = file;
                imageCont.appendChild(img);
                
                const checkbox = document.createElement('input');
                checkbox.name = 'files[]';
                checkbox.value = file;
                checkbox.setAttribute('type', 'checkbox');
                checkbox.setAttribute('click', () => event.stopPropagation());
                imageCont.appendChild(checkbox);

                $('#imagePreviewCont').append(imageCont);
            }
        },
        error: function() {
            messageFade('error', 'Noget gik galt med at loade billeder, prøv at genindlæse siden.');
        }
    })
});