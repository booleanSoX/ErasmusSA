    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Evita que se abra otra pestaña/recargue

        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const errorDiv = document.getElementById('error-message');

        // Ocultamos el error antes de volver a comprobar
        errorDiv.style.display = 'none';

        // 1. Comprobamos si las contraseñas coinciden antes de enviar nada
        if (password !== confirmPassword) {
            errorDiv.style.display = 'block';
            errorDiv.innerHTML = 'Error: Las contraseñas no coinciden.';
            return; // Detiene la ejecución aquí, no se envía al servidor
        }

        // 2. Si coinciden, empaquetamos y enviamos al servidor en segundo plano
        const formData = new FormData(this);

        fetch('register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Si la creación es correcta, redirigimos a main.php
                window.location.href = 'main.php';
            } else {
                // Si hay error (usuario existente), lo mostramos en el recuadro rojo
                errorDiv.style.display = 'block';
                errorDiv.innerHTML = data.message;
            }
        })
        .catch(error => {
            errorDiv.style.display = 'block';
            errorDiv.innerHTML = 'Error de conexión con el servidor.';
        });
    });