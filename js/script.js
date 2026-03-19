document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault(); 

            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const errorDiv = document.getElementById('error-message');

            errorDiv.style.display = 'none';

            if (password !== confirmPassword) {
                errorDiv.style.display = 'block';
                errorDiv.className = 'callout alert'; 
                errorDiv.textContent = 'Errore: le password non corrispondono.';
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
                    // Viaja a la ruta que le dio el PHP (index.html?msg=account_created)
                    window.location.href = data.redirect; 
                } else {
                    errorDiv.textContent = data.message;
                    errorDiv.style.display = 'block';
                    errorDiv.className = 'callout alert'; 
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorDiv.textContent = "Errore di comunicazione con il server.";
                errorDiv.style.display = 'block';
                errorDiv.className = 'callout alert';
            });
        });
    }
});