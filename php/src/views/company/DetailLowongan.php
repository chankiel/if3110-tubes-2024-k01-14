<?php
session_start();

$response = isset($_SESSION['response']) ? $_SESSION['response'] : null;

unset($_SESSION['response']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="/public/styles/style.css">
    <link rel="stylesheet" href="/public/styles/template/navbar.css">
    <link rel="stylesheet" href="/public/styles/template/modal.css">
    <link rel="stylesheet" href="/public/styles/company/DetailLowonganCompany.css">
</head>
<body>
    <main>
        <section class="detail-lowongan">
            <div class="heading-container">
                <p><?= $company_name ?></p>
                <h1 class="position-heading">
                    <?= $posisi ?>
                </h1>
            </div>
            <p class="small-details"><?= $company_lokasi ?> · Diposting <?= $lowongan_diffTime ?></p>
            <ul class="lowongan-details details-format">
                <li>
                    <span class="material-symbols-outlined">
                        person
                    </span>
                    <p><?= $posisi ?></p>
                </li>
                <li>
                    <span class="material-symbols-outlined">
                        work
                    </span>
                    <p><?= $jenis_pekerjaan ?></p>
                </li>
                <li>
                    <span class="material-symbols-outlined">
                        location_on
                    </span>
                    <p><?= $jenis_lokasi ?></p>
                </li>
            </ul>
            <h1 class="lowongan-heading">Tentang Pekerjaan Ini</h1>
            <p><?= $deskripsi ?></p>
            <form action="/jobs/<?=$id?>/delete" method="POST">
                <button type="submit" class="delete-job">Delete</button>
            </form>
            <button class="close-job">Close</button>
        </section>
        <div class="list-application">
            <?php if (empty($applications)): ?>
            <div class="no-application">
                <h2>No application available</h2>
            </div>
            <?php else: foreach ($applications as $application):?>
                <div class="preview-lamaran">
                    <?= $application["nama"];?>
                    <?= $application["status"];?>
                </div>
            <?php endforeach; endif;?>
        </div>
    </main>
</body>
</html>