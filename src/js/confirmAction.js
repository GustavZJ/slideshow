// Confirm action modal
export function confirmAction(action) {
    return new Promise((resolve, reject) => {
        const objConfirmModal = document.createElement('div');
        objConfirmModal.id = 'confirmModal';
        objConfirmModal.innerHTML = (`
        <div class='modalContent'>
        <p id="confirmMessage">Er du sikker på at du vil ${action}?</p>
        <button class="btnRed" id="cancelAction">Annuller</button>
        <button class="btnBlue" id="confirmAction">Slet</button>
        </div>
        `);

        document.body.appendChild(objConfirmModal);
        const confirmModal = document.getElementById('confirmModal');
        confirmModal.style.display = 'block';

        const confirmActionBtn = document.getElementById('confirmAction');
        confirmActionBtn.addEventListener('click', () => {
            confirmModal.remove();
            resolve();
        });

        const cancelActionBtn = document.getElementById('cancelAction');
        cancelActionBtn.addEventListener('click', () => {
            confirmModal.remove();
            reject();
        });
    });
}