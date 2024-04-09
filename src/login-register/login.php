<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
include "./../static_component/header.php";

if (isset($_SESSION["dresseur"])) {
    header("Location: /pokedex/index.php");
    exit;
}

$error_message = "";

if (isset($_POST["login"])) {
    $username_email = $_POST["username_email"];
    $password = $_POST["password"]; 
    require_once "./../db/config-bdd.php";

    if (filter_var($username_email, FILTER_VALIDATE_EMAIL)) {
        $query = "SELECT * FROM dresseur WHERE email = ?";
    } else {
        $query = "SELECT * FROM dresseur WHERE nom_dresseur = ?"; 
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $dresseur = $result->fetch_assoc();

    if ($dresseur && password_verify($password, $dresseur["mdp_dresseur"])) {
        $_SESSION["dresseur"] = "yes";
        $_SESSION["user_email"] = $dresseur["email"];
        $_SESSION["dresseur_id"] = $dresseur["id_dresseur"]; 
        $_SESSION['dresseur_nom'] = $dresseur['nom_dresseur'];
        header("Location: ./../pages/index.php");
        exit;
    } else {
        $error_message = "Nom de dresseur ou mot de passe incorrect";
    }
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Connexion</div>
                <div class="card-body">
                    <form action="login.php" method="post">
                        <?php if (!empty($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>
                        <div class="form-group">
                            <input type="text" placeholder="Entrer l'email ou le nom de dresseur" name="username_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Entrer le mot de passe" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Connexion" name="login" class="btn btn-primary">
                        </div>
                    </form>
                    <div class="form-group">
                        <a href="register.php" class="btn btn-link">S'inscrire ici</a>
                        <a href="forgot-password.php" class="btn btn-link">Mot de passe oublié ?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
