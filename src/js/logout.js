jQuery(document).ready(function ($) {
    // Function to bind the click event to the #logoutBtn
    function bindLogoutEvent() {
        $('#logoutBtn').click(function () {
            $.ajax({
                type: 'POST',
                url: '/src/php/logout.php',
                success: function() {
                    window.location.pathname = '/index.html';
                }
            });
        });
    }

    // Check if #topbar is already in the DOM
    if ($('#topbar').length) {
        bindLogoutEvent();
    } else {
        // Create a MutationObserver to detect when #topbar is added to the DOM
        const observer = new MutationObserver(function (mutations, observer) {
            if ($('#topbar').length) {
                bindLogoutEvent();
                observer.disconnect(); // Stop observing once #topbar is found
            }
        });

        // Start observing the document for changes
        observer.observe(document.body, { childList: true, subtree: true });
    }
});