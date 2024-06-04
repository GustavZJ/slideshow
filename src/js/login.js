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
                    try {
                        const jsonResponse = JSON.parse(response);
                        if (jsonResponse.redirect) {
                            window.location.href = jsonResponse.redirect;
                        } else {
                            $('#loginText').text(jsonResponse.message || response);
                        }
                    } catch (e) {
                        $('#loginText').text('Noget gik galt! Prøv igen. 1');
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