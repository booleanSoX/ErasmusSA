// public/assets/js/modules/auth.js
import { showError } from '../utils/notifications.js';

export function initLogin(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const errorDiv = document.getElementById('error-message');
        errorDiv.style.display = 'none';

        try {
            // El Router espera 'login', no 'login.php' ni 'index.php'
const response = await fetch('login', { 
    method: 'POST', 
    body: new FormData(this) 
});

            
            if (data.status === 'success') {
                window.location.href = 'main'; // O la ruta que defina tu Router
            } else {
                showError(errorDiv, data.message);
            }
        } catch (error) {
            showError(errorDiv, 'Error de conexión con el servidor.');
        }
    });
}