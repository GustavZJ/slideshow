import { messageFade } from "/src/js/errorMessage.js"

jQuery(document).ready(function ($) {
    $("#recoverBtn").click(function () {   
        $.ajax({
            type: 'POST',
            url: '/src/php/restoreBackup.php',
            success: function (response) {
                if (response.exit_code === 0) {
                    messageFade("success", "Alle billeder er gendannet!");
                } else {
                    messageFade("error", "Der var en fejl :(");
                }

            },
            error: function () {
                messageFade("error", "Der var en fejl :(");
            }
        });
    });
    
});