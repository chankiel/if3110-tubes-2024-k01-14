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
                        <a href="/">
                        <span class="material-symbols-outlined navbar-icon iconn" id="home-icon">
                            home
                        </span>
                        <p>Home</p>
                        </a>
                    </li>
                    <?php if ($user['role'] == "jobseeker"): ?>
                        <li class="icon">
                            <a href="/applications">
                            <span class="material-symbols-outlined navbar-icon" id="history-icon">
                                history
                            </span>
                            <p>History</p>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="icon" id="iconTrigger">
                            <img src="/public/images/linkedin.png" alt="logo">
                            <p class="name-link">Me <span class="material-symbols-outlined arrow-down">
                                    arrow_drop_down
                                </span> </p>
                            <div id="popover" class="popover-content hidden">
                                <div class="pop-profile">
                                    <img src="/public/images/perry-casino.jpg" alt="profile-pic">
                                    <div class="profile-details">
                                        <h1><?= $user['nama']?></h1>
                                        <h2><?= ucfirst($user['role'])?></h2>
                                    </div>
                                </div>
                                <?php if($user['role']=="company"): ?>
                                    <a href="/profile/company" class="view-profile">View Profile</a>
                                <?php endif; ?>
                                <form action="/logout" method="POST" class="logout-form">
                                    <button type="submit" class="logout-btn">Logout</button>
                                </form>
                            </div>
                        </li>
                    <?php endif; ?>
                    <!-- Jika belum authed -->
                <?php else: ?>
                    <li><a href="/login" class="nav-btn login-btn">Login</a></li>
                    <li><a href="/register" class="nav-btn register-btn">Register</a></li>
                <?php endif; ?>

            </ul>
        </nav>
    </div>
</header>