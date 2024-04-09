<?php
include './../static_component/header.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/../db/config-bdd.php";

$sql = "SELECT * FROM dresseur
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    header("Location: forgot-password.php?message=Token%20invalid");
    exit(); 
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    header("Location: forgot-password.php?message=Token%20has%20expired");
    exit(); 
}

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Reset Password</div>
                <div class="card-body">
                    <form id="resetForm" method="post" action="process-reset-password.php">
                        <div class="mb-3">
                            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                            <label for="password" class="form-label">Nouveau mot de passe </label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Repeter le mot de passe</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="popup" class="popup">
    <span id="popupMessage"></span>
</div>

<script>
    document.getElementById("resetForm").addEventListener("submit", function(event) {
        event.preventDefault();
        
        var form = this;
        var formData = new FormData(form);

        fetch(form.action, {
            method: form.method,
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            showPopup(data);
            form.reset();
            setTimeout(function() {
                window.location.href = "login.php";
            }, 3000); 
        })
        .catch(error => console.error('Error:', error));
    });

    function showPopup(message) {
        var popup = document.getElementById("popup");
        var popupMessage = document.getElementById("popupMessage");
        popupMessage.textContent = message;
        popup.style.display = "block";

        setTimeout(function() {
            popup.style.display = "none";
        }, 6000); 
    }
</script>

</body>
</html>
