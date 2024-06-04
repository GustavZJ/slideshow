jQuery(document).ready(function ($) {
    $(window).load(function () {
        $('#loginBtn').submit(function (event) {
            console.log($(this), $(this).serialize);
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
            event.preventDefault();
        });
    })
})