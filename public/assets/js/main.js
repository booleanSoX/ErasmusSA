// public/assets/js/main.js
import { checkUrlMessages } from './utils/notifications.js';
import { initLogin } from './modules/auth.js';
import { initRegister } from './modules/register.js';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Verificar mensajes en la URL (Toasts)
    checkUrlMessages();

    // 2. Inicializar formularios si existen en la página actual
    initLogin('loginForm');
    initRegister('registerForm');
});