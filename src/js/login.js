import { messageFade } from '/src/js/errorMessage.js';

jQuery(document).ready(function ($) {
    $(window).on('load', function () {
        $('#loginWrapper').submit(function (event) {
            event.preventDefault();  // Prevent the default form submission
            $.ajax({
                type: 'POST',
                url: '/src/php/login.php',
                data: $(this).serialize(),
                success: function (response) {
                    if (response.hasOwnProperty('redirect')) {
                        window.location.href = response['redirect'];
                    } else {
                        messageFade('error', 'Forkert kodeord.');
                    }
                },
                error: function () {
                    messageFade('error', 'Noget gik galt, prøv igen.');
                }
            });
        });
    });
});