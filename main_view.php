<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ERP</title>
    <link rel="stylesheet" href="css/foundation.css">
</head>
<body>

<nav class="banner-wrapper" style="background: #252525; padding: 1rem;">
    <img class="top-banner" src="https://www.softwarengineering.it/assets/img/logo_softwarengineering_blubordobianco.png" alt="Logo ERP" style="height: 50px;">
    
    <a href="profile.php" class="button" style="margin-right: 0.5rem;">Profilo</a>
    
    <a href="logout.php" class="button alert">Logout</a>
</nav>

<div class="dashboard-content">
    <div class="grid-container">

        <div class="grid-x grid-padding-x align-center">
            <div class="cell small-12 medium-10 large-8">
                <h2 class="text-center title-white">
                    Benvenuto <?php echo htmlspecialchars($_SESSION['username']); ?>
                </h2>
            </div>
        </div>

        <div class="grid-x grid-padding-x align-center">
            <div class="cell small-12 medium-10 large-8 card-box">
                <h3 class="text-center">Utenti</h3>
                <div class="table-scroll-container">
                    <table class="unstriped hover">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Nome</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = pg_fetch_assoc($users_result)) {
                                echo "<tr>
                                        <td>".htmlspecialchars($row['username'])."</td>
                                        <td>".htmlspecialchars($row['email'])."</td>
                                        <td>".htmlspecialchars($row['name'])." ".htmlspecialchars($row['last_name'])."</td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
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
                        <tbody>
                            <?php
                            while ($domain = pg_fetch_assoc($domains_result)) {
                                $state_label = 'success';
                                if (strtolower($domain['domain_state']) === 'in attesa di rinnovo') $state_label = 'warning';
                                elseif (strtolower($domain['domain_state']) === 'oziare') $state_label = 'alert';
                                echo "<tr>
                                        <td>".htmlspecialchars($domain['domain_name'])."</td>
                                        <td><span class='{$state_label} label'>".htmlspecialchars($domain['domain_state'])."</span></td>
                                      </tr>";
                            }
                            ?>
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
                            <?php
                            while ($email = pg_fetch_assoc($emails_result)) {
                                echo "<tr>
                                        <td>".htmlspecialchars($email['email_address'])."</td>
                                        <td>".htmlspecialchars($email['domain_name'])."</td>
                                        <td>".htmlspecialchars($email['size'])."</td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>