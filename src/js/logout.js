jQuery(document).ready(function ($) {
    $('#topbar').load(function () {
        $('#logoutBtn').click(function () {
            $.ajax({
                type: 'POST',
                url: '/src/php/logout.php',
                success: function() {
                    window.location.pathname = '/index.html';
                }
            });
        });
    })
});