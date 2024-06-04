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
                        const jsonResponse = JSON.parse(response);
                        console.log(jsonResponse, response);
                        if (jsonResponse['redirect']) {
                            window.location.href = jsonResponse['redirect'];
                        } else {
                            $('#loginText').text(jsonResponse['message']);
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