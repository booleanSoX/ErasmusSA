// public/assets/js/modules/register.js
import { showError } from '../utils/notifications.js';

export function initRegister(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const errorDiv = document.getElementById('error-message');
        const formData = new FormData(this);
        
        // Validación de negocio
        if (formData.get('password') !== formData.get('confirm_password')) {
            showError(errorDiv, 'Errore: le password non corrispondono.');
            return;
        }

        try {
            // Importante: La ruta debe ser el endpoint del Router ('register' no 'register.php')
            const response = await fetch('register', { method: 'POST', body: formData });
            const data = await response.json();

            if (data.status === 'success') {
                window.location.href = data.redirect || 'index?msg=account_created';
            } else {
                showError(errorDiv, data.message);
            }
        } catch (error) {
            showError(errorDiv, 'Errore di comunicazione con il server.');
        }
    });
}