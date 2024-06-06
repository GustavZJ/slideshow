jQuery(document).ready(function ($) {
    console.log('ready');
    $('#topbar').on('load', function () {
        console.log('load');
        $('#logoutBtn').click(function () {
            console.log('click');
            $.ajax({
                type: 'POST',
                url: '/src/php/logout.php',
                success: function() {
                    window.location.pathname = '/index.html';
                }
            });
        });
    });
});