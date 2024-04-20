export {messageFade};

// Message modal fade in / out
const messageModalColor = {'error':'white', 'success':'green'};
let fadeTimer;
let deleteTimer;

// Modal based timed message
function messageFade(type, message) {
    // Create modal
    const errorModal = document.createElement('div');
    errorModal.id = 'messageModalContent';
    errorModal.innerHTML = (`<div> <!-- This div is intentional -->
    <p id="statusMessage"></p>
    </div>`)

    // Append modal to HTML
    document.body.appendChild(errorModal);

    const messageModalContent = document.getElementById('messageModalContent');
    const statusMessage = document.getElementById('statusMessage');

    // Clear all timers, to prevent new timer from finishing early
    clearTimeout(fadeTimer);
    clearTimeout(deleteTimer);
    messageModalContent.style.backgroundColor = messageModalColor[type.toLowerCase()]; // Set matching color of modal
    statusMessage.innerHTML = message; // Set message
    setTimeout(() => {
        messageModalContent.style.opacity = 1; // This somehow ensure that it fades in, even when appended from JS
    }, 0);
    fadeTimer = setTimeout(() => {
        messageModalContent.style.opacity = 0; // Modal fade out
        deleteTimer = setTimeout(() => {
            errorModal.remove(); // Remove modal after fade out
        }, 250)
    }, 5000);
}