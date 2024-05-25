// Confirm action modal
export function confirmAction(action) {
    return new Promise((resolve) => {
        // Generate unique ID for each dialog
        const dailogId = `confirmDialog-${Date.now()}-${Math.random().toString(36).substring(2, 9)}`;

        // Create the dialog element
        const confirmDialog = document.createElement('dialog');
        confirmDialog.id = dailogId;
        confirmDialog.className = 'confirmDialog';
        confirmDialog.setAttribute('autofocus', 'true');
        confirmDialog.innerHTML = (`
            <p id="confirmMessage">Er du sikker på at du vil ${action}?</p>
            <button class="btnBlue" id="cancelActionBtn">Annuller</button>
            <button class="btnRed" id="confirmActionBtn">Slet</button>
        `);

        document.body.appendChild(confirmDialog);
        const confirmDialogEle = document.getElementById(dailogId);
        
        // Show the dialog
        confirmDialogEle.showModal();

        const confirmActionBtn = document.getElementById('confirmActionBtn');
        confirmActionBtn.addEventListener('click', () => {
            confirmDialogEle.close();
            confirmDialogEle.remove();
            resolve(true);
        });

        const cancelActionBtn = document.getElementById('cancelActionBtn');
        cancelActionBtn.addEventListener('click', () => {
            confirmDialogEle.close();
            confirmDialogEle.remove();
            resolve(false);
        });
    });
}