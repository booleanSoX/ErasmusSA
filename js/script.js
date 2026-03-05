const usuarioActual = {
            nombre: "Sebas",
            rol: "admin"
}

document.getElementById('user-name-placeholder').textContent = usuarioActual.nombre;
if (usuarioActual.rol === 'admin') {
    document.getElementById('admin-docs-section').classList.remove('admin-only');        }
