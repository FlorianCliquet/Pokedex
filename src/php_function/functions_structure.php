<?php

function displayPokedex($mysqli, $pokedex) {
    echo '<div class="pokedex">';
    foreach ($pokedex as $pokemon) { 
        echo '<div class="card" style="width: 18rem; margin: 50px;">';
        if (count($pokemon['images']) > 1) {
            $carousel_base_id = 'carousel_' . $pokemon['id_pokemon'] . '_' . uniqid(); 
            echo '<div id="' . $carousel_base_id . '" class="carousel slide" data-ride="carousel">';
            echo '<ol class="carousel-indicators">';
            foreach ($pokemon['images'] as $index => $image) {
                $activeClass = ($index === 0) ? 'active' : '';
                echo '<li data-target="#' . $carousel_base_id . '" data-slide-to="' . $index . '" class="' . $activeClass . '"></li>';
            }
            echo '</ol>';
            echo '<div class="carousel-inner bg-dark">';
            foreach ($pokemon['images'] as $index => $image) {
                $activeClass = ($index === 0) ? 'active' : '';
                echo '<div class="carousel-item ' . $activeClass . '">';
                echo '<a href="./pokemon.php?pokemon_id=' . $pokemon['id_pokemon'] . '">';
                echo '<img class="d-block w-100" src="./../../assets/' . $image . '" alt="' . $pokemon['nom'] . '">';
                echo '</a>';
                echo '</div>';
            }
            echo '</div>';
            echo '<a class="carousel-control-prev" href="#' . $carousel_base_id . '" role="button" data-slide="prev">';
            echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
            echo '<span class="sr-only">Previous</span>';
            echo '</a>';
            echo '<a class="carousel-control-next" href="#' . $carousel_base_id . '" role="button" data-slide="next">';
            echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
            echo '<span class="sr-only">Next</span>';
            echo '</a>';
            echo '</div>';
        } else {
            echo '<a href="pokemon.php?pokemon_id=' . $pokemon['id_pokemon'] . '">';
            echo '<img class="card-img-top" src="./assets/' . $pokemon['images'][0] . '" alt="' . $pokemon['nom'] . '">';
            echo '</a>';
        }
        echo '<div class="card-body">';
        echo '<h5 class="card-title text-center">' . $pokemon['nom'] . '</h5>';
        
        $types = getPokemonTypes($mysqli, $pokemon['id_pokemon']);
        echo '<div class="types">';
        echo '<ul class="list-inline">';
        foreach ($types as $type):
            $imagePath = './../../assets/Images/types/Miniature_Type_' . $type['libelle'] . '_EV.png';
            echo '<li class="list-inline-item type_logo"><img src="' . $imagePath . '" alt="' . $type['libelle'] . '"></li>';
        endforeach;
        echo '</ul>';
        echo '</div>';
        
        echo '<p class="card-text text-center">#' . $pokemon['numero'] . '</p>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
}

function displayPokemon($pokemon, $level = 0) {
    
    if (empty($pokemon) || !isset($pokemon[0])) {
        echo "Ce pokémon n'a pas d'évolution.";
        echo '</div>';
        return; 
    }
    $evolutions = $pokemon[0]['evolutions'] ?? []; 

    echo '<div class="pokedex' . $level . '">';
    echo '<div class="text-align-center">'; 
    echo '<a href="./pokemon.php?pokemon_id=' . $pokemon[0]['id_pokemon'] . '" >'; 
    echo '<img src="./../../assets/' . $pokemon[0]['chemin'] . '" alt="' . $pokemon[0]['nom'] . '" style="width: 116px; height: auto;">';
    echo '<p>' . $pokemon[0]['nom'] . ' - Level: ' . $pokemon[0]['niveau'] . '</p>';
    echo '</a>'; 
    echo '</div>'; 

    if (empty($evolutions)) {
        return; 
    }

    foreach ($evolutions as $evolution) {
        echo '<div class="pokedex' . $level . '">';
        echo '<div class="text-align-center">';
        echo '<a href="./pokemon.php?pokemon_id=' . $evolution['id_pokemon'] . '">';
        echo '<img src="./../../assets/' . $evolution['chemin'] . '" alt="' . $evolution['nom'] . '" style="width: 116px; height: auto;">';
        echo '<p>' . $evolution['nom'] . ' - Level: ' . $evolution['niveau'] . '</p>'; 
        echo '</a>'; 

        if (!empty($evolution['evolutions'])) {
            displayPokemon([$evolution], $level + 1);
        }

        echo '</div>'; 
    }
}
function displayownPokedex($mysqli, $pokedex) { 
    echo '<div class="pokedex">';
    foreach ($pokedex as $pokemon) { 
        $blurStyle = ($pokemon['nbAttrape'] == 0 ) && ($pokemon['nbVue'] == 0 ) ? 'blurStyle' : '';
        echo '<div class="card" style="width: 18rem; margin: 50px;">';
        if (count($pokemon['images']) > 1) {
            $carousel_base_id = 'carousel_' . $pokemon['id_pokemon'] . '_' . uniqid(); 
            echo '<div id="' . $carousel_base_id . '" class="carousel slide" data-ride="carousel">';
            echo '<ol class="carousel-indicators">';
            foreach ($pokemon['images'] as $index => $image) {
                $activeClass = ($index === 0) ? 'active' : '';
                echo '<li data-target="#' . $carousel_base_id . '" data-slide-to="' . $index . '" class="' . $activeClass . '"></li>';
            }
            echo '</ol>';
            echo '<div class="carousel-inner bg-dark">';
            foreach ($pokemon['images'] as $index => $image) {
                $activeClass = ($index === 0) ? 'active' : '';
                echo '<div class="carousel-item ' . $activeClass . '">';
                echo '<a href="./pokemon.php?pokemon_id=' . $pokemon['id_pokemon'] . '">';
                echo '<img class="d-block w-100 ' . $blurStyle . '" src="./../../assets/' . $image . '" alt="' . $pokemon['nom'] . '">';
                echo '</a>';
                echo '</div>';
            }
            echo '</div>';
            echo '<a class="carousel-control-prev" href="#' . $carousel_base_id . '" role="button" data-slide="prev">';
            echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
            echo '<span class="sr-only">Previous</span>';
            echo '</a>';
            echo '<a class="carousel-control-next" href="#' . $carousel_base_id . '" role="button" data-slide="next">';
            echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
            echo '<span class="sr-only">Next</span>';
            echo '</a>';
            echo '</div>';
        } else {
            echo '<a href="pokemon.php?pokemon_id=' . $pokemon['id_pokemon'] . '">';
            echo '<img class="card-img-top ' . $blurStyle . '" src="./assets/' . $pokemon['images'][0] . '" alt="' . $pokemon['nom'] . '">';
            echo '</a>';
        }
        echo '<div class="card-body text-center">';
        echo '<h5 class="card-title mb-0">' . $pokemon['nom'] . '</h5>';
        
        $types = getPokemonTypes($mysqli, $pokemon['id_pokemon']);
        echo '<div class="types">';
        echo '<ul class="list-inline">';
        foreach ($types as $type):
            $imagePath = './../../assets/Images/types/Miniature_Type_' . $type['libelle'] . '_EV.png';
            echo '<li class="list-inline-item type_logo"><img src="' . $imagePath . '" alt="' . $type['libelle'] . '"></li>';
        endforeach;
        echo '</ul>';
        echo '</div>';
        
        if ($pokemon['nbAttrape'] > 0) {
            echo '<img src="./../../assets/Images/pokedex/caught.png" alt="Pokémon attrapé" class="status-logo">';
        }
        else if ($pokemon['nbVue'] > 0) {
            echo '<img src="./../../assets/Images/pokedex/seen.png" alt="Pokémon vu" class="status-logo">';
        }
        echo '<p class="card-text">#' . $pokemon['numero'] . '</p>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
}

?>
