<!DOCTYPE html>
<html>
<head>
    <title>Pokedex</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="icon" type="image" href="./../../assets/Images/Icone/pokeball.png" />
    <link
        href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap"
        rel="stylesheet"
        />
    <link rel="stylesheet" href="./../../assets/css/style.css">
</head>
<body>
    <header class="header">
        <div class="wrap_logo">
            <a href="./../pages/index.php">
            <img class="logo" src="./../../assets/Images/header/Pokedex.png" width="168" height="60" alt="Logo">
        </div>
        <div>
        <p class="name">
                <?php
                session_start();
                if (isset($_SESSION['dresseur'])) {
                    echo 'Pokedex de ' . $_SESSION['dresseur_nom'];
                } else {
                    echo 'Pokedex de la 1ère Génération';
                }
                ?>
            </p>
        </div>
        <nav>
            <ul class="nav_links">
                <?php
                if (isset($_SESSION['dresseur'])) {
                    echo '<li><a href="pokedex.php" class="btn btn-primary">Pokemon attrapé/vu  </a></li>';
                    echo '<li></li>';
                    echo '<li><a href="modify_pokedex.php" class="btn btn-primary">Modifier pokedex</a></li>';
                    echo '<li></li>';
                    echo '<li><a href="./../login-register/logout.php" class="btn btn-primary">Déconnexion</a></li>';
                } else {
                    echo '<li><a href="./../login-register/login.php" class="btn btn-primary">Connection</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>
    <main>
