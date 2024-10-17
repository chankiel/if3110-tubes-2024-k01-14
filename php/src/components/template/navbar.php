<header class="">
    <div class="header-container">
        <a class="logo-container" href="/">
            <img src="/public/images/linkedin.png" alt="logo">
        </a>
        <nav class="navbar ">
            <ul class="navbar-list ">

                <!-- Jika authed -->
                <?php if (true): ?>
                    <li class="home">
                        <span class="material-symbols-outlined navbar-icon">
                            home
                        </span>
                        <a href="/">Home</a>
                    </li>
                    <?php if (false): ?>
                        <li class="history">
                            <span class="material-symbols-outlined navbar-icon">
                                history
                            </span>
                            <a href="/">History</a>
                        </li>
                    <?php else: ?>
                        <li class="home">
                            <img src="/public/images/linkedin.png" alt="logo">
                            <a href="/" class="name-link">Ignatius</a>
                        </li>
                    <?php endif; ?>
                    <!-- Jika belum authed -->
                <?php else: ?>
                    <li><a href="/login" class="login-btn">Login</a></li>
                    <li><a href="/register" class="register-btn">Register</a></li>
                <?php endif; ?>

            </ul>
        </nav>
    </div>
</header>