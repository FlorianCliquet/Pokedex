<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
include './../db/config-bdd.php';
include './../php_function/functions_query.php';
include './../php_function/functions_structure.php';
include './../static_component/header.php';

$dresseur_id = $_SESSION['dresseur_id'];

$pokedex = getDresseurownPokedex($mysqli, $dresseur_id);
?>

<main>
    <div class=" text-center">
        <?php displayownPokedex($mysqli,$pokedex); ?>
    </div>
</main>

<footer>
    <p>&copy; 2024 Pokedex</p>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$mysqli->close();
?>
