
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\public\styles\general\register-login.css">
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
            <form action="/login" method="POST">
                <label for="email">Email</label>
                <input type="email" name="email" required>

                <label for="password">Password</label>
                <input type="password" name="password" required>

                <button type="submit">Sign In</button>

                <div class="redirect-register-login">
                    <p>New to LinkedIn? <a href="/register">Join now</a></p>
                </div>
            </form>
        </div>
    </section>

    <footer>
    </footer>
</body>
</html>
