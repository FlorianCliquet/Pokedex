<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

$error_message = ""; 

if (isset($_POST["login"])) {
   $email = $_POST["email"];
   $password = $_POST["password"];
    require_once "database.php";
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user"] = "yes";
        $_SESSION["user_email"] = $user["email"];
        header("Location: /TheGoodReviews/index.php");
        exit;
    } else {
        $error_message = "Email or password does not match";
    }
}
include_once "header.php";
?>
<div class="showcase">
    <div class="video-container">
        <video src="../../media/loginbackground.mp4" autoplay muted loop id="myVideo"></video>
    <div>
</div>
    <div class="container">
    <form action="login.php" method="post">
      <div class="login-box">
        <h2>Login</h2>
        <?php if(!empty($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?> <!-- Display error message if it exists -->
        <div class="user-box">
            <input type="email" placeholder="Enter Email:" name="email" class="form-control">
            <label>Email</label>
        </div>
        <div class="user-box">
            <input type="password" placeholder="Enter Password:"  name="password" class="form-control">
            <label>Password</label>
        </div>
        <div class="btn">
            <input type="submit" value="Login" name="login" class="btn btn--login">
        </div>
      </form>
      
      <div class="form-btn">
        <a href="register.php" class="btn--register">Register Here</a>
    </div>
        <div class="form-btn">
        <a href="forgot-password.php" class="btn--forgotpassword">Forgot password?</a>
        </div>
    </div>
</div>
</body>
</html>
