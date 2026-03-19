    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault(); 

        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const errorDiv = document.getElementById('error-message');

        errorDiv.style.display = 'none';

        if (password !== confirmPassword) {
            errorDiv.style.display = 'block';
            errorDiv.innerHTML = 'Error: Las contraseñas no coinciden.';
            return; 
        }

        const formData = new FormData(this);

        fetch('register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                window.location.href = 'main.php';
            } else {
                errorDiv.style.display = 'block';
                errorDiv.innerHTML = data.message;
            }
        })
        .catch(error => {
            errorDiv.style.display = 'block';
            errorDiv.innerHTML = 'Error de conexión con el servidor.';
        });
    });