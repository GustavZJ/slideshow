jQuery(document).ready(function ($) {
    $(window).on('load', function () {
        $('#loginWrapper').submit(function (event) {
            event.preventDefault();  // Prevent the default form submission
            console.log(event);
            console.log($(this), $(this).serialize());
            $.ajax({
                type: 'POST',
                url: '/src/php/login.php',
                data: $(this).serialize(),
                success: function (response) {
                    console.log(response);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });
    });
});