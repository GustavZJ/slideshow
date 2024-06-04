jQuery(document).ready(function ($) {
    $(window).on('load', function () {
        $('#loginWrapper').submit(function (event) {
            event.preventDefault();  // Prevent the default form submission
            clearTimeout();
            $.ajax({
                type: 'POST',
                url: '/src/php/login.php',
                data: $(this).serialize(),
                success: function (response) {
                    // Parse the JSON response
                        if (response['redirect']) {
                            console.log(response['redirect'])
                            window.location.href = response['redirect'];
                        } else {
                            $('#loginText').text(response['message']);
                        }
                    setTimeout(() => {
                        $('#loginText').text('');
                    }, 5000);
                },
                error: function () {
                    $('#loginText').text('Noget gik galt! Prøv igen.');
                    setTimeout(() => {
                        $('#loginText').text('');
                    }, 5000);
                }
            });
        });
    });
});