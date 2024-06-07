import { messageFade } from '/src/js/errorMessage.js';
import { disableBtns } from '/src/js/deleteImage.js';

jQuery(document).ready(function ($) {
    function decodeHtmlEntities(target, str) {
        return $(target).html(str).text();
    }

    $.ajax({
        type: 'POST',
        url: '/src/php/loadImages.php',
        success: function(response) {
            if (response) {
                $('#deleteBtn, #deleteAllBtn').css('display', 'inline-block');
                $('#deletePreviewText').css('display', 'none');
            }

            response.forEach(file => {
                const $imageCont = $('<div>', { class: 'imageCont elePointerIcon' });

                $imageCont.on('click', function(event) {
                    const $checkbox = $(this).find('input[type="checkbox"]');
                    $checkbox.prop('checked', !$checkbox.prop('checked'));
                    disableBtns();

                    if ($checkbox.prop('checked')) {
                        $('#deleteBtn').removeAttr('disabled');
                    }
                });

                const $img = $('<img>', { class: 'previewImage', src: `/uploads/${file}` });
                const $checkbox = $('<input>', {
                    name: 'files[]',
                    value: decodeHtmlEntities(this, file),
                    type: 'checkbox'
                });

                $checkbox.on('click', function(event) {
                    event.stopPropagation();
                    disableBtns();
                });

                $imageCont.append($img).append($checkbox);
                $('#imagePreviewCont').append($imageCont);
            });
        },
        error: function() {
            messageFade('error', 'Noget gik galt med at loade billeder, prøv at genindlæse siden.');
        }
    });
});