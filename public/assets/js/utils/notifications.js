// public/assets/js/utils/notifications.js

export const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 6000,
    timerProgressBar: true,
});

export function checkUrlMessages() {
    const params = new URLSearchParams(window.location.search);
    const msg = params.get('msg');

    const messages = {
        'account_created': 'Account creato con successo!',
        'password_changed': 'Password cambiata con successo!'
    };

    if (msg && messages[msg]) {
        Toast.fire({
            icon: 'success',
            title: messages[msg]
        });
        // Limpia la URL sin recargar
        window.history.replaceState({}, document.title, window.location.pathname);
    }
}

export function showError(element, message) {
    if (!element) return;
    element.style.display = 'block';
    element.className = 'callout alert';
    element.textContent = message;
}