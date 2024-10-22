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
    <?php
    include(dirname(__DIR__) . '/../components/template/navbar.php');
    include(dirname(__DIR__) . '/../components/template/modal.php')
    ?>
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
            <h1 class="lowongan-heading">Job Description</h1>
            <p><?= $deskripsi ?></p>
            <form action="/jobs/<?=$id?>/delete" method="POST">
                <form action="/jobs/<?=$id?>/close" method="POST" class="container-button">
                <button type="submit" class="general-button">Delete Job</button>
            </form>
            <form action="/jobs/<?=$id?>/close" method="POST" class="container-button">
                <?php if ($is_open) :?>
                <button name="action" value="close" class="general-button">Close Job</button>
                <?php else : ?>
                <button name="action" value="open" class="general-button">Open Job</button>
                <?php endif;?>
            </form>
        </section>
        <section>
            <div class="list-application">
            <?php if (empty($applications)): ?>
            <div class="no-application">
                <h2 class="no-application">No application available</h2>
            </div>
            <?php else: ?>
                <h1 class="lowongan-heading">List Application</h1>
                <?php foreach ($applications as $application):?>
                    <div class="preview-lamaran">
                        <div class="nama-status">
                            <p class="nama"> Name : <?= $application["nama"];?></p>
                            <p class="status">Status : <?= ucfirst($application["status"]);?></p>
                        </div>
                        <form action="/applications/<?= $application["user_id"] ?>" method="GET">
                            <button type="submit" class="general-button">
                                View Details
                            </button>
                        </form>
                    </div>
                <?php endforeach; endif;?>
            </div>
        </section>
        <?php if ($response): ?>
            <?php if ($response['success']): ?>
                <?php modal("success", $response['message']); ?>
            <?php elseif (!$response['success']): ?>
                <?php modal("error", $response['message'], $response["errors"]); ?>
            <?php endif; ?>
        <?php endif; ?>
                    
    </main>
</body>
<script src="/public/scripts/template/modal.js"></script>
</html>