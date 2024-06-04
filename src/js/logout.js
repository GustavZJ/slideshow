jQuery(document).ready(function ($) {
    $('#logoutBtn').click(function () {
        $.ajax({
            type: 'POST',
            url: '/src/php/logout.php'
        })
    })
});