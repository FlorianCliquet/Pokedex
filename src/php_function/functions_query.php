<?php

function getPokedex($mysqli) {
    $sql = "SELECT pokemon.id_pokemon, pokemon.numero, pokemon.nom, COALESCE(pokedex.nbVue, 0) AS nbVue, COALESCE(pokedex.nbAttrape, 0) AS nbAttrape, GROUP_CONCAT(image.chemin) AS image_paths
            FROM pokemon
            LEFT JOIN pokedex ON pokemon.id_pokemon = pokedex.id_pokemon
            LEFT JOIN image ON pokemon.id_pokemon = image.id_pokemon
            GROUP BY pokemon.id_pokemon
            ORDER BY pokemon.numero";
    $result = $mysqli->query($sql);
    $pokedex = [];
    while ($row = $result->fetch_assoc()) {
        $imagePaths = explode(',', trim($row['image_paths'], ','));
        $imagePaths = array_filter($imagePaths); 
        $imagePaths = array_unique($imagePaths);
        $row['images'] = $imagePaths; 
        unset($row['image_paths']);
        $pokedex[] = $row;
    }
    return $pokedex;
}

function getownGlobalPokedex($mysqli, $dresseur_id) {
    $sql = "SELECT pokemon.id_pokemon, pokemon.numero, pokemon.nom, COALESCE(pokedex.nbVue, 0) AS nbVue, COALESCE(pokedex.nbAttrape, 0) AS nbAttrape, GROUP_CONCAT(image.chemin) AS image_paths
            FROM pokemon
            LEFT JOIN pokedex ON pokemon.id_pokemon = pokedex.id_pokemon AND pokedex.id_dresseur = ?
            LEFT JOIN image ON pokemon.id_pokemon = image.id_pokemon
            GROUP BY pokemon.id_pokemon
            ORDER BY pokemon.numero";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $dresseur_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $pokedex = [];
    while ($row = $result->fetch_assoc()) {
        $imagePaths = explode(',', trim($row['image_paths'], ','));
        $imagePaths = array_filter($imagePaths); 
        $imagePaths = array_unique($imagePaths);
        $row['images'] = $imagePaths; 
        unset($row['image_paths']);
        $pokedex[] = $row;
    }
    return $pokedex;
}
function getPokemonViewAndCatchCounts($mysqli, $pokemon_id, $dresseur_id) {
    $sql = "SELECT nbVue, nbAttrape FROM pokedex WHERE id_pokemon = ? AND id_dresseur = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $pokemon_id, $dresseur_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}






function getDresseurownPokedex($mysqli, $dresseur_id) {
    $sql = "SELECT pokemon.id_pokemon, pokemon.numero, pokemon.nom, pokemon.description, pokemon.taille, pokemon.poids, COALESCE(pokedex.nbVue, 0) AS nbVue, COALESCE(pokedex.nbAttrape, 0) AS nbAttrape, GROUP_CONCAT(image.chemin) AS image_paths
            FROM pokedex
            JOIN pokemon ON pokedex.id_pokemon = pokemon.id_pokemon
            LEFT JOIN image ON pokemon.id_pokemon = image.id_pokemon
            WHERE pokedex.id_dresseur = ?
            GROUP BY pokemon.id_pokemon";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $dresseur_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pokedex = [];
    while ($row = $result->fetch_assoc()) {
        $imagePaths = explode(',', $row['image_paths']);
        $imagePaths = array_filter($imagePaths);
        $row['images'] = $imagePaths;
        unset($row['image_paths']);
        $pokedex[] = $row;
    }
    $stmt->close();
    return $pokedex;
}
function getPokemonInfo($mysqli, $pokemon_id) {
    $sql = "SELECT * FROM pokemon WHERE id_pokemon = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $pokemon_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pokemon_info = $result->fetch_assoc();
    $stmt->close();
    return $pokemon_info;
}

function getPokemonTypes($mysqli, $pokemon_id) {
    $sql = "SELECT t.libelle FROM type t JOIN esttype et ON t.id_type = et.id_type WHERE et.id_pokemon = ?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param("i", $pokemon_id);
    if (!$stmt->execute()) {
        return false;
    }
    $result = $stmt->get_result();
    if (!$result) {
        return false;
    }
    $types = array();
    while ($row = $result->fetch_assoc()) {
        $types[] = $row;
    }
    $stmt->close();
    return $types;
}


function getPokemonAbilities($mysqli, $pokemon_id) {
    $sql = "SELECT c.id_capacite, c.libelle_capacite, c.pp_capacite, c.precision_capacite, c.puissance_capacite, t.libelle AS type 
            FROM capacite c 
            JOIN lance l ON c.id_capacite = l.id_capacite 
            JOIN type t ON c.id_type = t.id_type
            WHERE l.id_pokemon = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $pokemon_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $abilities = array();
    while ($row = $result->fetch_assoc()) {
        $abilities[] = $row;
    }
    $stmt->close();
    return $abilities;
}


function getPokemonEvolutions($mysqli, $pokemon_id) {
    $sql = "SELECT DISTINCT p.id_pokemon, p.nom AS nom, 
            (SELECT i.chemin FROM image i WHERE i.id_pokemon = p.id_pokemon LIMIT 1) AS chemin,
            e.niveau AS niveau
            FROM pokemon p
            JOIN evolue e ON p.id_pokemon = e.id_pokemon_evolue
            WHERE e.id_pokemon_base = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $pokemon_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $evolutions = array();
    while ($row = $result->fetch_assoc()) {
        $row['evolutions'] = getPokemonEvolutions($mysqli, $row['id_pokemon']);
        $evolutions[] = $row;
    }
    $stmt->close();
    return $evolutions;
}

function getPokemonImages($mysqli, $pokemon_id) {
    $sql = "SELECT CONCAT('./../../assets/', chemin) AS chemin FROM image WHERE id_pokemon = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $pokemon_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $images = array();
    while ($row = $result->fetch_assoc()) {
        $images[] = $row;
    }
    $stmt->close();
    return $images;
}



?>