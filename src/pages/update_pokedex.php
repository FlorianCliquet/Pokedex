<?php
session_start();

if (!isset($_SESSION['dresseur_id'])) {
    header('Location: login.php');
    exit;
}

include './../db/config-bdd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pokemonId = $_POST['pokemon'];
    $nbVue = $_POST['nbVue'];
    $nbAttrape = $_POST['nbAttrape'];
    $dresseurId = $_SESSION['dresseur_id'];

    $sqlCheck = "SELECT * FROM pokedex WHERE id_pokemon = ? AND id_dresseur = ?";
    $stmtCheck = $mysqli->prepare($sqlCheck);
    $stmtCheck->bind_param("ii", $pokemonId, $dresseurId);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        $sqlUpdate = "UPDATE pokedex SET nbVue = ?, nbAttrape = ? WHERE id_pokemon = ? AND id_dresseur = ?";
        $stmtUpdate = $mysqli->prepare($sqlUpdate);
        $stmtUpdate->bind_param("iiii", $nbVue, $nbAttrape, $pokemonId, $dresseurId);
        $stmtUpdate->execute();
    } else {
        $sqlInsert = "INSERT INTO pokedex (id_pokemon, id_dresseur, nbVue, nbAttrape) VALUES (?, ?, ?, ?)";
        $stmtInsert = $mysqli->prepare($sqlInsert);
        $stmtInsert->bind_param("iiii", $pokemonId, $dresseurId, $nbVue, $nbAttrape);
        $stmtInsert->execute();
    }

    header('Location: modify_pokedex.php');
    exit;
}
?>
