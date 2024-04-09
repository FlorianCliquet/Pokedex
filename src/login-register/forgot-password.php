<?php
include "./../static_component/header.php";
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Mot de passe oublié</div>
                <div class="card-body">
                    <form action="send-password-reset.php" method="post">
                        <div class="form-group">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary w-100">Envoyer</button>
                        </div>
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
    document.addEventListener("DOMContentLoaded", function() {
        var message = "<?php echo isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '' ?>";
        if (message) {
            showPopup(message);
        }   
    });

    function showPopup(message) {
        var popup = document.getElementById("popup");
        var popupMessage = document.getElementById("popupMessage");
        popupMessage.textContent = message;
        popup.style.display = "block";

        setTimeout(function() {
            popup.style.display = "none";
        }, 12000); 
    }
</script>
</body>
</html>
