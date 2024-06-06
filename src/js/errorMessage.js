// Modal based timed message
export function messageFade(type, message) {
    const messageModalColor = {'error': 'white', 'success': 'green'};

    if (type == "no_msg") {
        return null;
    }
    
    // Generate unique ID for each dialog
    const dialogId = `errorDialog-${Date.now()}-${Math.random().toString(36).substring(2, 9)}`;
    
    // Create modal
    const errorDialog = document.createElement('dialog');
    errorDialog.id = dialogId;
    errorDialog.className = 'errorDialog';
    errorDialog.innerHTML = message;
    errorDialog.style.backgroundColor = messageModalColor[type.toLowerCase()];
    document.body.appendChild(errorDialog);
    const errorDialogEle = document.getElementById(dialogId);

    // Position the dialog dynamically based on the number of visible dialogs
    const visibleDialogs = document.querySelectorAll('.errorDialog').length;
    errorDialogEle.style.top = `${20 + (visibleDialogs * 5)}%`;

    // This fixes issue with modal not fading in, and instead appearing abruptly
    setTimeout(() => {
        errorDialogEle.style.opacity = 1;
    }, 0);

    errorDialogEle.show();
    
    // Set up fade out and delete timers for this specific modal
    setTimeout(() => {
        errorDialogEle.style.opacity = 0;
        // Only delete after fade out
        setTimeout(() => {
            errorDialogEle.close();
            errorDialogEle.remove();

            // Reposition remaining dialogs to fill the gap
            const remainingDialogs = document.querySelectorAll('.errorDialog');
            remainingDialogs.forEach((dialog, index) => {
                dialog.style.top = `${20 + ((index + 1) * 5)}%`;
            });
        }, 250);
    }, 5000);
}