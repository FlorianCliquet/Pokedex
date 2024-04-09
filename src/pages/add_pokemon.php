<?php
include './../db/config-bdd.php';
include './../php_function/functions_query.php';

session_start();

if (!isset($_SESSION['dresseur'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pokemon_id = $_POST['pokemon_id'];
    $dresseur_id = $_SESSION['dresseur_id'];

    $sqlCheck = "SELECT * FROM pokedex WHERE id_pokemon = ? AND id_dresseur = ?";
    $stmtCheck = $mysqli->prepare($sqlCheck);
    $stmtCheck->bind_param("ii", $pokemon_id, $dresseur_id);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows == 0) {
        $sqlInsert = "INSERT INTO pokedex (id_pokemon, id_dresseur, nbVue, nbAttrape) VALUES (?, ?, 1, 1)";
        $stmtInsert = $mysqli->prepare($sqlInsert);
        $stmtInsert->bind_param("ii", $pokemon_id, $dresseur_id);
        $stmtInsert->execute();
    }

    header('Location: pokemon.php?pokemon_id=' . $pokemon_id);
    exit;
}
?>
