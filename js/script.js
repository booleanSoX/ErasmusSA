document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Evitamos que el formulario recargue la página por defecto

    const formData = new FormData(this);
    const errorDiv = document.getElementById('error-message');

    fetch('register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // Convertimos la respuesta del PHP a objeto JS
    .then(data => {
        if (data.status === 'success') {
            // AQUÍ es donde ocurre la redirección si el usuario se creó con éxito
            window.location.href = data.redirect; 
        } else {
            // Si hay un error (ej. usuario ya existe), se muestra en el div sin recargar
            errorDiv.textContent = data.message;
            errorDiv.style.display = 'block';
            errorDiv.className = 'callout alert'; // Clase de Foundation para errores
        }
    })
    .catch(error => {
        console.error('Error:', error);
        errorDiv.textContent = "Error de comunicación con el servidor.";
        errorDiv.style.display = 'block';
    });
});