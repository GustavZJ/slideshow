jQuery(document).ready(function ($) {
    $(window).on('load', function () {
        $('#loginWrapper').submit(function (event) {
            clearTimeout();
            $.ajax({
                type: 'POST',
                url: '/src/php/login.php',
                data: $(this).serialize(),
                success: function (response) {
                    $('#loginText').text(response);
                    setTimeout(() => {
                        $('#loginText').text('');
                    }, 5000)
                },
                error: function () {
                    $('#loginText').text('Noget gik galt! Prøv igen');
                    setTimeout(() => {
                        $('#loginText').text('');
                    }, 5000)
                }
            });
        });
    });
});