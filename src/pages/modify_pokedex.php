<?php
session_start();

if (!isset($_SESSION['dresseur'])) {
    header('Location: login.php');
    exit;
}

include './../db/config-bdd.php';
include './../static_component/header.php';

$sql = "SELECT id_pokemon, nom FROM pokemon";
$result = $mysqli->query($sql);
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Mettre à jour le Pokedex</div>
                <div class="card-body">
                    <form action="update_pokedex.php" method="post">
                        <div class="mb-3">
                            <label for="pokemon" class="form-label">Choisir son Pokémon:</label>
                            <select name="pokemon" id="pokemon" class="form-select">
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id_pokemon']; ?>"><?php echo $row['nom']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nbVue" class="form-label">Modifier le nombre de vue:</label>
                            <input type="number" name="nbVue" id="nbVue" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="nbAttrape" class="form-label">Modifier le nombre de Pokémon de cette espèce attrapée:</label>
                            <input type="number" name="nbAttrape" id="nbAttrape" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include './../static_component/footer.php';
?>
