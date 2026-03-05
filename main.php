<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

$host = "localhost";
$db   = "users";
$user = "perugia";
$pass = "PERUGIAPSW";

$conn = pg_connect("host=$host dbname=$db user=$user password=$pass");
if (!$conn) die("Errore di connessione al database.");

$users_result   = pg_query($conn, "SELECT id_user, username, email, name, last_name FROM users ORDER BY username ASC");
$domains_result = pg_query($conn, "SELECT domain_name, domain_state FROM domains ORDER BY domain_name ASC");
$emails_result  = pg_query($conn, "SELECT email AS email_address, domain_name, size FROM emails ORDER BY email ASC");
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pannello utente - ERP</title>
    <link rel="stylesheet" href="css/foundation.css">
</head>
<body>

<nav class="banner-wrapper">
    <img class="top-banner" src="https://www.softwarengineering.it/assets/img/logo_softwarengineering_blubordobianco.png" alt="Logo ERP">
    <a href="logout.php" class="button alert" style="float:right; margin:10px;">Logout</a>
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
                            while ($user = pg_fetch_assoc($users_result)) {
                                echo "<tr>
                                        <td>".htmlspecialchars($user['username'])."</td>
                                        <td>".htmlspecialchars($user['email'])."</td>
                                        <td>".htmlspecialchars($user['name'])." ".htmlspecialchars($user['last_name'])."</td>
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