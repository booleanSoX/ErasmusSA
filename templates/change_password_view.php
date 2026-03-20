<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambia Password</title>
    <link rel="stylesheet" href="css/foundation.css">
</head>
<body style="min-height: 100vh; display: flex; flex-direction: column; background: #252525; margin: 0;">

<nav class="banner-wrapper">
    <img class="top-banner" src="https://www.softwarengineering.it/assets/img/logo_softwarengineering_blubordobianco.png" alt="Logo">
</nav>

<div class="main-content">
    <div class="grid-container" style="width: 100%;">
        <div class="grid-x grid-padding-x align-center">
            <div class="cell small-11 medium-8 large-5" style="background: white; color: black; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-top: 2rem;">

                <h2 class="text-center">Cambia Password</h2>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="callout alert" style="border-radius: 4px; border: none; background-color: #cc4b37; color: white;">
                        <p style="margin-bottom: 0;"><?php echo htmlspecialchars($_SESSION['error']); ?></p>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form action="change_password.php" method="POST">
                    <label for="new_password">Nueva contraseña
                        <input type="password" id="new_password" name="new_password" required>
                    </label>

                    <label for="confirm_new_password">Confirmar nueva contraseña
                        <input type="password" id="confirm_new_password" name="confirm_new_password" required>
                    </label>

                    <button type="submit" class="button expanded" style="margin-top: 1rem;">Actualizar Password</button>
                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>