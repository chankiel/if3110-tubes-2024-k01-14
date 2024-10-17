<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="../public/styles/style.css">
    <link rel="stylesheet" href="../public/styles/template/navbar.css">
    <link rel="stylesheet" href="../public/styles/jobseeker/RiwayatJobSeeker.css">

</head>

<body>
    <?php include(dirname(__DIR__) . '/components/template/navbar.php') ?>
    <main>
        <h1>Riwayat Lamaran <?= $user ?></h1>
        <section>
            <ul>
                <li class="lamaran-item">
                    <a class="lamaran-link">
                        <h1 class="role">
                            Software Engineer
                        </h1>
                        <h2 class="company">
                            at Agoda
                        </h2>
                        <p class="details">
                            <span class="material-symbols-outlined">
                                work
                            </span>
                            Internship - Full Time
                        </p>
                        <h3 class="status rejected">Rejected</h3>
                    </a>
                </li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </section>
    </main>
</body>

</html>