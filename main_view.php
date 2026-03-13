<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ERP</title>
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* 1. Fondo general oscuro */
        body { 
            background-color: #252525; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .title-main { color: white; margin-top: 2rem; }

        /* 2. Marco de los cuadros en azul */
        .card-box {
            background: #4783cb; 
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
            margin-bottom: 2rem;
        }

        /* 3. Títulos de secciones en blanco */
        .card-box h3 { 
            color: white !important; 
            font-weight: 600;
            margin-bottom: 1rem;
        }

        /* Contenedor de la tabla en blanco */
        .table-scroll-container {
            max-height: 300px;
            overflow-y: auto;
            background: white;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        /* Texto de las tablas siempre en NEGRO */
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

        table tbody td { color: #000 !important; }

        /* Estilos de las etiquetas de Estado */
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: bold;
            color: white;
            display: inline-block;
            text-transform: uppercase;
        }
        .status-active { background-color: #28a745; }   /* Verde */
        .status-warning { background-color: #ffc107; color: #000 !important; } /* Amarillo */
        .status-danger { background-color: #dc3545; }    /* Rojo */
        .status-secondary { background-color: #6c757d; } /* Gris */

        .btn-download { color: #4783cb; font-size: 1.2rem; }
        .btn-download:hover { color: #3567a1; transform: scale(1.1); }

        .table-scroll-container::-webkit-scrollbar { width: 8px; }
        .table-scroll-container::-webkit-scrollbar-track { background: #f1f1f1; }
        .table-scroll-container::-webkit-scrollbar-thumb { background: #888; border-radius: 4px; }
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
                <h3 class="text-center">Dominios</h3>
                <div class="table-scroll-container">
                    <table class="unstriped hover">
                        <thead>
                            <tr>
                                <th>Nombre del dominio</th>
                                <th>Estado</th>
                                <th>Fecha Registro</th>
                                <th>Fecha Caducidad</th>
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
                <h3 class="text-center">Correos</h3>
                <div class="table-scroll-container">
                    <table class="unstriped hover">
                        <thead>
                            <tr>
                                <th>Nombre del correo</th>
                                <th>Tamaño</th>
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
                                <th>Descargar</th>
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

</body>
</html>