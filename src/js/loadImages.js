import { messageFade } from '/src/js/errorMessage.js';
import { disableBtns } from '/src/js/deleteImage.js';

jQuery(document).ready(function ($) {
    function decodeHtmlEntities(str) {
        var txt = document.createElement('textarea');
        txt.innerHTML = str;
        return txt.value;
    }

    $.ajax({
        type: 'POST',
        url: '/src/php/loadImages.php',
        success: function(response) {
            if (response && Array.isArray(response)) {
                if (response.length > 0) {
                    $('#deleteBtn, #deleteAllBtn').css('display', 'inline-block');
                    $('#deletePreviewText').css('display', 'none');
                }

                response.forEach(file => {
                    const $imageCont = $('<div>', { class: 'imageCont elePointerIcon' });

                    $imageCont.on('click', function() {
                        const $checkbox = $(this).find('input[type="checkbox"]');
                        $checkbox.prop('checked', !$checkbox.prop('checked'));
                        disableBtns();

                        if ($checkbox.prop('checked')) {
                            $('#deleteBtn').removeAttr('disabled');
                        }
                    });

                    const decodedFile = decodeHtmlEntities(file);
                    const $img = $('<img>', { class: 'previewImage', src: `/uploads/${decodedFile}` });
                    const $checkbox = $('<input>', {
                        name: 'files[]',
                        value: decodedFile,
                        type: 'checkbox'
                    });

                    $checkbox.on('click', function(event) {
                        event.stopPropagation();
                        disableBtns();
                    });

                    $imageCont.append($img).append($checkbox);
                    $('#imagePreviewCont').append($imageCont);
                });
            }
        },
        error: function() {
            messageFade('error', 'Noget gik galt med at loade billeder, prøv at genindlæse siden.');
        }
    });
});