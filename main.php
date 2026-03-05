<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pannello utente - ERP</title>
    <link rel="stylesheet" href="css/foundation.css" crossorigin="anonymous">
   <script src="js/script.js" defer></script>
</head>
<body>

    <nav class="banner-wrapper">
        <img class="top-banner" src="https://www.softwarengineering.it/assets/img/logo_softwarengineering_blubordobianco.png" alt="Logo ERP">
    </nav>
    
    <div class="dashboard-content">
        <div class="grid-container">

            <div class="grid-x grid-padding-x align-center">
                <div class="cell small-12 medium-10 large-8">
                    <h2 class="text-center title-white">Benvenuto <span id="user-name-placeholder">...</span></h2>
                </div>
            </div>

            <div class="grid-x grid-padding-x align-center">
                <div class="cell small-12 medium-10 large-8 card-box">
                    <h3 class="text-center">Domini</h3>
                    <div class="table-scroll-container">
                        <table class="unstriped hover">
                            <thead>
                                <tr>
                                    <th>Nome di dominio</th>
                                    <th>Stato</th>
                                </tr>
                            </thead>
                            <tbody id="domains-table-body">
                                <tr>
                                    <td>erp-system.com</td>
                                    <td><span class="success label">Risorsa</span></td>
                                </tr>
                                <tr>
                                    <td>tech-cloud.net</td>
                                    <td><span class="warning label">In attesa di rinnovo</span></td>
                                </tr>
                                <tr>
                                    <td>institute_perugia.org</td>
                                    <td><span class="alert label">Oziare</span></td>
                                </tr>
                                <tr>
                                    <td>treitalia.com</td>
                                    <td><span class="warning label">In attesa di rinnovo</span></td>
                                </tr>                                
                                <tr>
                                    <td>domini.com</td>
                                    <td><span class="success label">Risorsa</span></td>
                                </tr>                                
                                <tr>
                                    <td>save_sebas.org</td>
                                    <td><span class="success label">Risorsa</span></td>
                                </tr>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="grid-x grid-padding-x align-center">
                <div class="cell small-12 medium-10 large-8 card-box">
                    <h3 class="text-center">E-mail</h3>
                    <div class="table-scroll-container">
                        <table class="unstriped hover">
                            <thead>
                                <tr>
                                    <th>E-mail</th>
                                    <th>Dominio</th>
                                    <th>Dimensione</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>admin@erp-system.com</td>
                                    <td>erp-system.com</td>
                                    <td>1.2 GB</td>
                                </tr>
                                <tr>
                                    <td>saldi@tech-cloud.net</td>
                                    <td>tech-cloud.net</td>
                                    <td>450 MB</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="grid-x grid-padding-x align-center admin-only" id="admin-docs-section">
                <div class="cell small-12 medium-10 large-8 card-box" style="border-left: 5px solid #cc4b37;">
                    <h3 class="text-center">Documenti (solo visualizzazione)</h3>
                    <div class="table-scroll-container">
                        <table class="unstriped hover">
                            <thead>
                                <tr>
                                    <th>File</th>
                                    <th>Data</th>
                                    <th>Azione</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>vendite_del_mese.pdf</td>
                                    <td>2026-03-01</td>
                                    <td><button class="button-small">
                                        <img src="descargar.png" style="width: 25px; height: px;">
                                    </button></td>
                                </tr>
                                <tr>
                                    <td>contratti_dipendente.zip</td>
                                    <td>2026-02-15</td>
                                    <td><button class="button-small">
                                        <img src="descargar.png" style="width: 25px; height: 25px;">
                                    </button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    
</body>
</html>