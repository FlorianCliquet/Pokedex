<?php
include './../db/config-bdd.php';
include './../php_function/functions_query.php';
include './../php_function/functions_structure.php';
include './../static_component/header.php';

if (!isset($_GET['pokemon_id'])) {
    header("Location: index.php");
    exit();
}

$pokemon_id = $_GET['pokemon_id'];

$pokemon_info = getPokemonInfo($mysqli, $pokemon_id);

if (!$pokemon_info) {
    header("Location: index.php");
    exit();
}

$types = getPokemonTypes($mysqli, $pokemon_id);
$abilities = getPokemonAbilities($mysqli, $pokemon_id);
$evolutions = getPokemonEvolutions($mysqli, $pokemon_id);
$images = getPokemonImages($mysqli, $pokemon_id);

$dresseur_id = $_SESSION['dresseur_id'];

$viewAndCatchCounts = getPokemonViewAndCatchCounts($mysqli, $pokemon_id, $dresseur_id);
?>

<main>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card flex-fill">
                    <div class="card-header d-flex align-items-center">
                        <h1 class="card-title"><?php echo $pokemon_info['nom']; ?></h1>
                        <?php foreach ($images as $image) : ?>
                            <?php if (str_ends_with($image['chemin'], '.gif')): ?>
                                <img src="<?php echo $image['chemin']; ?>" alt="Image of <?php echo $pokemon_info['nom']; ?>" style="width: 50px; height: auto;">
                                <?php break;?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h2>Information</h2>
                                <p><strong>Numéro:</strong> #<?php echo $pokemon_info['numero']; ?></p>
                                <p><strong>Description:</strong> <?php echo $pokemon_info['description']; ?></p>
                                <p><strong>Taille:</strong> <?php echo $pokemon_info['taille']; ?> m</p>
                                <p><strong>Poids:</strong> <?php echo $pokemon_info['poids']; ?> kg</p>
                                <img src="./../../assets/Images/pokemon/<?php echo $pokemon_info['numero']; ?>.png" alt="Image of <?php echo $pokemon_info['nom']; ?>">
                            </div>
                            <div class="col-md-6">
                                <h2>Types</h2>
                                <ul>
                                    <?php foreach ($types as $type): ?>
                                        <?php
                                            $imagePath = './../../assets/Images/types/Miniature_Type_' . $type['libelle'] . '_EV.png';
                                        ?>
                                        <img src="<?php echo $imagePath; ?>" alt="<?php echo $type['libelle']; ?>">
                                    <?php endforeach; ?>
                                </ul>
                                <h2>Capacités</h2>
                                <ul>
                                    <?php foreach ($abilities as $ability) : ?>
                                        <li class="ability" data-ability='<?php echo json_encode($ability); ?>'><?php echo $ability['libelle_capacite']; ?></li>
                                        <div class="ability-details " style="display: none;">
                                            <p><strong>Type:</strong> <?php echo $ability['type']; ?></p>
                                            <p><strong>PP:</strong> <?php echo $ability['pp_capacite']; ?></p>
                                            <p><strong>Precision:</strong> <?php echo $ability['precision_capacite']; ?></p>
                                            <p><strong>Puissance:</strong> <?php echo $ability['puissance_capacite']; ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <h2>Images</h2>
                        <div class="row">
                            <?php foreach ($images as $image) : ?>
                                <?php if (strpos($image['chemin'], 'sugimori') !== false) : ?>
                                    <?php
                                    $isShiny = strpos($image['chemin'], 'shiny') !== false;
                                    ?>
                                    <div class="col-md-4 mb-3">
                                        <img src="<?php echo $image['chemin']; ?>" class="img-fluid" alt="Image of <?php echo $pokemon_info['nom']; ?>">
                                        <?php if ($isShiny) : ?>
                                            <p class="text-center">Shiny <?php echo $pokemon_info['nom']; ?></p>
                                        <?php else : ?>
                                            <p class="text-center"><?php echo $pokemon_info['nom']; ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <h2>Évolution :</h2>
                        <?php displayPokemon($evolutions); ?>
                        <?php if (isset($_SESSION['dresseur'])) : ?>
                            <h2>Statistiques</h2>
                            <p><strong>Nombre de fois vu:</strong> 
                                <?php if($viewAndCatchCounts['nbVue'] > 0) :
                                    echo $viewAndCatchCounts['nbVue'];
                                else :
                                    echo "0";
                                endif; ?>
                            </p>
                            <p><strong>Nombre de fois attrapé:</strong> 
                                <?php if($viewAndCatchCounts['nbAttrape'] > 0) :
                                    echo $viewAndCatchCounts['nbAttrape'];
                                else :
                                    echo "0";
                                endif; ?>
                            </p>
                            <?php if ($viewAndCatchCounts['nbAttrape'] == 0 && $viewAndCatchCounts['nbVue'] == 0) : ?>
                                <div class="justify-content-center">
                                <form action="./add_pokemon.php" method="post">
                                    <input type="hidden" name="pokemon_id" value="<?php echo $pokemon_id; ?>">
                                    <button type="submit" class="btn btn-primary">Ajouter à mon pokedex</button>
                                </form>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2024 Pokédex</p>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('.ability').click(function() {
            $(this).next('.ability-details').toggle();
        });
    });
</script>
</body>
</html>

<?php
$mysqli->close();
?>
