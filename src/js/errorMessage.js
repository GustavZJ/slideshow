// Modal based timed message
export function messageFade(type, message) {
    const messageModalColor = {'error': 'white', 'success': 'green'};

    if (type == "no_msg") {
        return null;
    }
    
    // Generate unique ID for each dialog
    const dailogId = `errorDialog-${Date.now()}-${Math.random().toString(36).substring(2, 9)}`;
    
    // Create modal
    const errorDialog = document.createElement('dialog');
    errorDialog.id = dailogId;
    errorDialog.className = 'errorDialog';
    errorDialog.innerHTML = message;
    document.body.appendChild(errorDialog);
    const errorDialogEle = document.getElementById(dailogId);

    errorDialogEle.style.backgroundColor = messageModalColor[type.toLowerCase()];
    errorDialogEle.innerHTML = message;
    errorDialogEle.style.transition = 'opacity 0.25s';
    errorDialogEle.style.opacity = 0;

    // This fixes issue with modal not fading in, and instead appearing abruptly
    setTimeout(() => {
        errorDialogEle.style.opacity = 1;
    }, 0);

    
    errorDialogEle.show();
    // Set up fade out and delete timers for this specific modal
    const fadeTimer = setTimeout(() => {
        errorDialogEle.style.opacity = 0;
        // Only delete after fade out
        const deleteTimer = setTimeout(() => {
            errorDialogEle.close();
            errorDialogEle.remove();
        }, 250);
    }, 5000);
}
