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
    
    <a href="index.html" class="button" style="margin-right: 0.5rem;">Profilo</a>
    
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
                <h3 class="text-center">Domini</h3>
                <div class="table-scroll-container">
                    <table class="unstriped hover">
                     <tbody>
                        <?php $databaseViewer->displayDomains($_SESSION['user_id']); ?>
</tbody>

<tbody>
    <?php $databaseViewer->displayEmails($_SESSION['user_id']); ?>
</tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>