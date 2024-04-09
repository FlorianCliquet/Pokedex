<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$token = $_POST["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/../db/config-bdd.php";

$sql = "SELECT * FROM dresseur
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$dresseur = $result->fetch_assoc();

if ($dresseur === null) {
    die("Jeton introuvable");
}

if (strtotime($dresseur["reset_token_expires_at"]) <= time()) {
    die("Le jeton a expiré");
}

if (strlen($_POST["password"]) < 8) {
    die("Le mot de passe doit comporter au moins 8 caractères");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Le mot de passe doit contenir au moins une lettre");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Le mot de passe doit contenir au moins un chiffre");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Les mots de passe doivent correspondre");
}

$mot_de_passe = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE dresseur
        SET mdp_dresseur = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE email = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("ss", $mot_de_passe, $dresseur["email"]);

$stmt->execute();

echo "Mot de passe mis à jour. Vous pouvez maintenant vous connecter.";
?>