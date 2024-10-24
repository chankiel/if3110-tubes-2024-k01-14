<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["error_message"])) {
    $errorMessage = htmlentities($_SESSION["error_message"]);
    unset($_SESSION['error_message']);
} else {
    $errorMessage = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Show login page">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\public\styles\general\register-login.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <title>Sign In</title>
</head>
<body>
    <header>
        <div class="header-subtitle">
            Stay updated on your professional world
        </div>
    </header>

    <section class="form-register-login">
        <div class="register-login-container">
            <h1>Login</h1>
            <?php if ($errorMessage): ?>
                <div class="error-message" style="color: red; text-align: center; margin-bottom: 10px;">
                    <?= $errorMessage ?>
                </div>
            <?php endif; ?>
            
            <?php include dirname(__DIR__) . '/../components/login/loginForm.php' ?>
        </div>
    </section>

    <footer>
    </footer>
</body>
</html>
