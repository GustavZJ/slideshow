jQuery(document).ready(function ($) {
    // $(#loginBtn).load(function () {
        $('#loginBtn').submit(function (event) {
            event.preventDefault();
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
    // })
})