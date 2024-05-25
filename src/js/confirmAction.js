// Confirm action modal
export function confirmAction(action) {
    return new Promise((resolve) => {
        // Generate unique ID for each dialog
        const dailogId = `errorDialog-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
        // Create the dialog element
        const confirmDialog = document.createElement('dialog');
        confirmDialog.id = dailogId;
        confirmDialog.className = 'dailogId';
        confirmDialog.setAttribute('autofocus', 'true');
        confirmDialog.innerHTML = (`
            <p id="confirmMessage">Er du sikker på at du vil ${action}?</p>
            <button class="btnBlue" id="cancelAction">Annuller</button>
            <button class="btnRed" id="confirmAction">Slet</button>
        `);

        document.body.appendChild(confirmDialog);
        const confirmDialogEle = document.getElementById('confirmDialog');
        
        // Show the dialog
        confirmDialogEle.showModal();

        const confirmActionBtn = document.getElementById('confirmAction');
        confirmActionBtn.addEventListener('click', () => {
            confirmDialogEle.close();
            confirmDialogEle.remove();
            resolve(true);
        });

        const cancelActionBtn = document.getElementById('cancelAction');
        cancelActionBtn.addEventListener('click', () => {
            confirmDialogEle.close();
            confirmDialogEle.remove();
            resolve(false);
        });
    });
}