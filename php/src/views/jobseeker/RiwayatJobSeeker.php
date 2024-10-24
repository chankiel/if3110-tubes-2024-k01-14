<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="/public/styles/style.css">
    <link rel="stylesheet" href="/public/styles/template/navbar.css">
    <link rel="stylesheet" href="/public/styles/template/sidebar.css">
    <link rel="stylesheet" href="/public/styles/jobseeker/RiwayatJobSeeker.css">

</head>

<body>
    <?php include(dirname(__DIR__) . '/../components/template/navbar.php') ?>
    <main>
        <?php include(dirname(__DIR__) . '/../components/template/sidebar.php') ?>
        <section>
            <?php if(empty($lamarans)): ?>
                <div class="empty-desc">
                    You haven't applied to any Job<br><span class="history">Your Applications History will be listed here</span>
                </div>
            <?php endif; ?>
            <ul>
                <?php foreach ($lamarans as $lamaran): ?>
                    <li class="lamaran-item">
                        <a class="lamaran-link" href="/jobs/<?= $lamaran["lowongan_id"] ?>/details">
                            <div class="top-container">
                                <h1 class="role">
                                    <?= $lamaran['posisi'] ?>
                                </h1>
                                <h3 class="status <?= $lamaran['status'] ?>"><?= ucfirst($lamaran['status']) ?></h3>
                            </div>
                            <h2 class="company">
                                at <?= $lamaran['company_name'] ?>
                            </h2>
                            <p class="details">
                                <span class="material-symbols-outlined">
                                    work
                                </span>
                                <?= $lamaran['jenis_pekerjaan'] ?> - <?= $lamaran['jenis_lokasi'] ?>
                            </p>
                            
                            <p class="date-container">Applied <span class="date-upload"><?= $lamaran['lamaran_diffTime'] ?></span> ago</p>
                        </a>
                    </li>
                <?php endforeach; ?>

            </ul>
        </section>
    </main>
</body>
<script src="/public/scripts/template/navbar.js"></script>

</html>