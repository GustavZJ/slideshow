jQuery(document).ready(function ($) {
    $('loginBtn').submit(function (event) {
        event.preventDefault();
        console.log('hello')
        $.ajax({
            type: 'POST',
            url: '/src/php/login.php',
            data: $(this).serialize(),
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
            },
            error: function (response) {
                console.log(response);
            }
        });
    });
})