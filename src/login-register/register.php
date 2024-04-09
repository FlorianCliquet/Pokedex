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
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">S'inscrire</div>
                <div class="card-body">
                <?php
                    if (isset($_POST["submit"])) {
                    $fullName = $_POST["nom_dresseur"];
                    $email = $_POST["email"];
                    $password = $_POST["mdp_dresseur"];
                    $passwordRepeat = $_POST["repeat_password"];
                    
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                    $errors = array();
                    
                    if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat)) {
                        array_push($errors,"Il faut remplir tous les champs");
                    }
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        array_push($errors, "L'email n'est pas valide");
                    }
                    if (strlen($password)<8) {
                        array_push($errors,"Le mot de passe de faire au moins 8 caractères");
                    }
                    if ($password!==$passwordRepeat) {
                        array_push($errors,"Les mots de passes ne match pas");
                    }
                    require_once "./../db/config-bdd.php";
                    $stmt = $conn->prepare("SELECT * FROM dresseur WHERE email = ?");
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $rowCount = $result->num_rows;
                    if ($rowCount>0) {
                        array_push($errors,"L'email existe déjà !");
                    }
                    if (count($errors)>0) {
                        foreach ($errors as $error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    } else {

                        $stmt = $conn->prepare("INSERT INTO dresseur (nom_dresseur, email, mdp_dresseur) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $fullName, $email, $passwordHash, );
                        if ($stmt->execute()) {
                            echo "<div class='alert alert-success'>Tu t'es connecté !</div>";
                        } else {
                            echo "Error: " . $stmt->error;
                        }
                        $stmt->close();
                    }
                    }
                    ?>
                    <form action="register.php" method="post">
                        <div class="form-group">
                            <input type="text" name="nom_dresseur" class="form-control" placeholder="Nom de dresseur" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="mdp_dresseur" class="form-control" placeholder="Mot de passe" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="repeat_password" class="form-control" placeholder="Repete le mot de passe" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="S'inscrire" name="submit">
                        </div>
                    </form>
                    <div class="form-group">
                        <a href="login.php" class="btn btn-link">Se connecter ici</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
