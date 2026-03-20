<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ERP</title>
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body { 
            background-color: #252525; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .title-main { color: white; margin-top: 2rem; }

        .card-box {
            background: #4783cb; 
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
            margin-bottom: 2rem;
        }

        .card-box h3 { 
            color: white !important; 
            font-weight: 600;
            margin-bottom: 1rem;
            position: relative; 
        }

        .table-scroll-container {
            max-height: 300px;
            overflow-y: auto;
            background: white;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        table { 
            background: white !important; 
            color: #000 !important; 
            margin-bottom: 0; 
            width: 100%;
        }

        table thead th { 
            background: #f1f1f1 !important; 
            color: #000 !important; 
            position: sticky;
            top: 0;
            z-index: 10;
        }

        table tbody td { color: #000 !important; vertical-align: middle; }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: bold;
            color: white;
            display: inline-block;
            text-transform: uppercase;
        }
        .status-active { background-color: #28a745; }   
        .status-warning { background-color: #ffc107; color: #000 !important; } 
        .status-danger { background-color: #dc3545; }   
        .status-secondary { background-color: #6c757d; } 

        .btn-download { color: #4783cb; font-size: 1.2rem; }
        .btn-download:hover { color: #3567a1; transform: scale(1.1); }

        .btn-add {
            position: absolute;
            right: 0; 
            top: 50%;
            transform: translateY(-50%);
            background: #28a745; 
            color: white;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            font-size: 1rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: transform 0.2s, background 0.2s;
        }
        .btn-add:hover {
            background: #218838;
            transform: translateY(-50%) scale(1.1); 
        }

        .btn-edit {
            color: #ffc107; 
            font-size: 1.2rem;
            cursor: pointer;
            transition: color 0.2s, transform 0.2s;
        }
        .btn-edit:hover {
            color: #e0a800;
            transform: scale(1.1);
        }

        .table-scroll-container::-webkit-scrollbar { width: 8px; }
        .table-scroll-container::-webkit-scrollbar-track { background: #f1f1f1; }
        .table-scroll-container::-webkit-scrollbar-thumb { background: #888; border-radius: 4px; }

        /* --- ESTILOS DE LA VENTANA MODAL --- */
        .modal-overlay {
            display: none; 
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            position: relative;
        }
        .modal-header h4 { margin-bottom: 1.5rem; color: #333; font-weight: bold; }
        .modal-close {
            position: absolute;
            top: 15px; right: 20px;
            font-size: 1.5rem;
            cursor: pointer;
            color: #888;
        }
        .modal-close:hover { color: #dc3545; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 0.5rem; color: #555;}
        .form-group input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .form-group input[readonly] { background-color: #e9ecef; cursor: not-allowed; }
        .btn-submit {
            background: #4783cb; color: white; padding: 10px 20px;
            border: none; border-radius: 4px; cursor: pointer;
            width: 100%; font-size: 1.1rem; font-weight: bold;
            margin-top: 1rem;
        }
        .btn-submit:hover { background: #3567a1; }
        .error-msg { color: #dc3545; font-size: 0.85rem; display: none; margin-top: 5px; }
    </style>
</head>
<body>

<nav class="banner-wrapper" style="background: #252525; padding: 1rem; border-bottom: 1px solid #444;">
    <a class="top-banner" href="logout.php">
        <img src="https://www.softwarengineering.it/assets/img/logo_softwarengineering_blubordobianco.png" alt="Logo ERP" style="height: 50px;">
    </a>
</nav>

<div class="dashboard-content">
    <div class="grid-container">

        <div class="grid-x grid-padding-x align-center">
            <div class="cell small-12 medium-10 large-8">
                <h2 class="text-center title-main">
                    Bienvenido <?php echo htmlspecialchars($_SESSION['username']); ?>
                </h2>
            </div>
        </div>

        <div class="grid-x grid-padding-x align-center">
            <div class="cell small-12 medium-10 large-8 card-box">
                <h3 class="text-center">
                    Dominios
                    <button class="btn-add" id="btnOpenDomainModal" title="Añadir Dominio"><i class="fa-solid fa-plus"></i></button>
                </h3>
                
                <div class="table-scroll-container">
                    <table class="unstriped hover">
                        <thead>
                            <tr>
                                <th>Nombre del dominio</th>
                                <th>Estado</th>
                                <th>Fecha Registro</th>
                                <th>Fecha Caducidad</th>
                                <th class="text-center">Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $databaseViewer->displayDomains($_SESSION['user_id']); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="grid-x grid-padding-x align-center">
            <div class="cell small-12 medium-10 large-8 card-box">
                <h3 class="text-center">
                    Correos
                    <button class="btn-add" title="Añadir Correo"><i class="fa-solid fa-plus"></i></button>
                </h3>
                <div class="table-scroll-container">
                    <table class="unstriped hover">
                        <thead>
                            <tr>
                                <th>Nombre del correo</th>
                                <th>ID Dominio</th>
                                <th>Espacio Actual</th>
                                <th>Límite de Cuota</th>
                                <th>Último Inicio de Sesión</th>
                                <th class="text-center">Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $databaseViewer->displayEmails($_SESSION['user_id']); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="grid-x grid-padding-x align-center">
            <div class="cell small-12 medium-10 large-8 card-box">
                <h3 class="text-center">Documentos</h3>
                <div class="table-scroll-container">
                    <table class="unstriped hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Ext.</th>
                                <th>Mime Type</th>
                                <th>Tamaño</th>
                                <th class="text-center">Descargar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $databaseViewer->displayFiles($_SESSION['user_id']); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal-overlay" id="domainModal">
    <div class="modal-content">
        <i class="fa-solid fa-xmark modal-close" id="btnCloseDomainModal"></i>
        <div class="modal-header">
            <h4>Registrar Nuevo Dominio</h4>
        </div>
        
        <form id="addDomainForm" action="add_domain.php" method="POST">
            <div class="form-group">
                <label for="domain_name">Nombre del Dominio</label>
                <input type="text" id="domain_name" name="domain_name" placeholder="ejemplo.com" required>
                <div class="error-msg" id="error-domain">El formato debe ser válido (ej. midominio.com).</div>
            </div>
            
            <div class="form-group">
                <label>Estado</label>
                <input type="text" value="Pendiente" disabled>
            </div>
            
            <div class="form-group">
                <label>Fecha de Registro</label>
                <input type="date" id="registration_date" name="registration_date" readonly>
            </div>
            
            <div class="form-group">
                <label for="expiration_date">Fecha de Caducidad</label>
                <input type="date" id="expiration_date" name="expiration_date" required>
                <div class="error-msg" id="error-date">La fecha de caducidad debe ser posterior a hoy.</div>
            </div>
            
            <button type="submit" class="btn-submit">Aceptar</button>
        </form>
    </div>
</div>
<script>
    // Referencias a los elementos del DOM
    const modal = document.getElementById('domainModal');
    const btnOpen = document.getElementById('btnOpenDomainModal');
    const btnClose = document.getElementById('btnCloseDomainModal');
    const form = document.getElementById('addDomainForm');
    
    const regDateInput = document.getElementById('registration_date');
    const expDateInput = document.getElementById('expiration_date');
    const domainInput = document.getElementById('domain_name');

    // Función para obtener la fecha de hoy en formato YYYY-MM-DD
    function getTodayString() {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        return `${yyyy}-${mm}-${dd}`;
    }

    // Abrir modal y configurar fecha de hoy
    btnOpen.addEventListener('click', () => {
        modal.style.display = 'flex';
        regDateInput.value = getTodayString(); // Siempre actualizado al día en que se hace click
        expDateInput.min = getTodayString();   // No dejar elegir días anteriores en el calendario
    });

    // Cerrar modal
    btnClose.addEventListener('click', () => { modal.style.display = 'none'; });
    
    // Cerrar si se hace click fuera de la caja blanca
    window.addEventListener('click', (e) => {
        if (e.target === modal) { modal.style.display = 'none'; }
    });

    // Validación antes de enviar
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Expresión regular para validar dominios
        const domainRegex = /^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}$/;
        if (!domainRegex.test(domainInput.value)) {
            document.getElementById('error-domain').style.display = 'block';
            isValid = false;
        } else {
            document.getElementById('error-domain').style.display = 'none';
        }

        // Validación de fechas
        if (expDateInput.value <= regDateInput.value) {
            document.getElementById('error-date').style.display = 'block';
            isValid = false;
        } else {
            document.getElementById('error-date').style.display = 'none';
        }

        if (!isValid) {
            e.preventDefault(); // Detiene el envío del formulario si hay errores
        }
    });
</script>

</body>
</html>