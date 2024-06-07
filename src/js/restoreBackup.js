jQuery(document).ready(function ($) {
    $("#recoverBtn").click(function () {   
        $.ajax({
            type: 'POST',
            url: '/src/php/restoreBackup.php',
        });
    });
    
});