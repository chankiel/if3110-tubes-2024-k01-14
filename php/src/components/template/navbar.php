<header class="">
    <div class="header-container">
        <a class="logo-container" href="/">
            <img src="/public/images/linkedin.png" alt="logo">
        </a>
        <nav class="navbar ">
            <ul class="navbar-list ">

                <!-- Jika authed -->
                <?php if ($success): ?>
                    <li class="icon">
                        <span class="material-symbols-outlined navbar-icon">
                            home
                        </span>
                        <a href="/">Home</a>
                    </li>
                    <?php if ($user['role'] == "jobseeker"): ?>
                        <li class="icon">
                            <span class="material-symbols-outlined navbar-icon">
                                history
                            </span>
                            <a href="/applications">History</a>
                        </li>
                    <?php else: ?>
                        <li class="icon">
                            <img src="/public/images/linkedin.png" alt="logo">
                            <a href="/" class="name-link">Ignatius</a>
                        </li>
                    <?php endif; ?>
                    <form action="/logout" method="POST">
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                    <!-- Jika belum authed -->
                <?php else: ?>
                    <li><a href="/login" class="login-btn">Login</a></li>
                    <li><a href="/register" class="register-btn">Register</a></li>
                <?php endif; ?>

            </ul>
        </nav>
    </div>
</header>