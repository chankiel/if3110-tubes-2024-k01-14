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
    <link rel="stylesheet" href="../../public/styles/template/sidebar.css">
    <link rel="stylesheet" href="/public/styles/company/DetailLowonganCompany.css">
    <!-- <link rel="stylesheet" href="/public/styles/jobseeker/DetailLowongan.css"> -->
</head>
<body>
    <?php
    include(dirname(__DIR__) . '/../components/template/navbar.php');
    include(dirname(__DIR__) . '/../components/template/modal.php')
    ?>
    <main>
        <?php
        include(dirname(__DIR__) . '/../components/template/sidebar.php');
        ?>
        <section>
            <div class="heading-container">
                <div class="company-container">
                    <span class="material-symbols-outlined">
                        apartment
                    </span>
                    <p><?= $company_name ?></p>
                </div>
                <h1 class="position-heading">
                    <?= $posisi ?>
                </h1>
            </div>
            <p class="small-details"><?= $company_lokasi ?> · Posted <?= $lowongan_diffTime ?> ago</p>
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
            <div class="container-button">
                <form action="/jobs/<?=$id?>/delete" method="POST">
                    <form action="/jobs/<?=$id?>/close" method="POST">
                    <button type="submit" class="general-button">Delete Job</button>
                </form>
                <form action="/jobs/<?=$id?>/close" method="POST">
                    <?php if ($is_open) :?>
                    <button name="action" value="close" class="general-button">Close Job</button>
                    <?php else : ?>
                    <button name="action" value="open" class="general-button">Open Job</button>
                    <?php endif;?>
                </form>
            </div>
            <h1 class="lowongan-heading">Job Description</h1>
            <p><?= $deskripsi ?></p>

            <?php if ($attachments): ?>
                <div>
                    <h1 class="lowongan-heading">Attachments</h1>
                    <div class="attachments-container">
                        <?php foreach ($attachments as $attachment): ?>
                            <a href="<?= $attachment ?>" target="_blank">
                                <img src="<?= $attachment  ?>" alt="attachment-img" class="attachment-img">
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
                            
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
                        <a href="/applications/<?= $application["lamaran_id"] ?>">
                            <button class="general-button">      
                                View Details
                            </button>
                        </a>
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