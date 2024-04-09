<?php
include './../db/config-bdd.php';
include './../php_function/functions_query.php';
include './../php_function/functions_structure.php';
include '../static_component/header.php';

?>
    <main>
        <?php
            echo '<pre>';
            print_r($_SESSION['id_dresseur']);
            echo '</pre>';
            if (isset($_SESSION['dresseur'])) {
                    $pokedex = getownGlobalPokedex($mysqli, $_SESSION['dresseur_id']);
                    displayownPokedex($mysqli,$pokedex);
                } else {
                    $pokedex = getPokedex($mysqli);
                    displayPokedex($mysqli,$pokedex);
                }
        ?>
    </main>

    <footer>
        <p>&copy; 2024 Pokedex</p>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$mysqli->close();
?>
