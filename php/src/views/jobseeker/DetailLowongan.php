<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
    <link rel="stylesheet" href="/public/styles/template/sidebar.css">
    <link rel="stylesheet" href="/public/styles/template/toast.css">
    <link rel="stylesheet" href="/public/styles/jobseeker/DetailLowongan.css">
</head>

<body>
    <?php
    include(dirname(__DIR__) . '/../components/template/navbar.php');
    include(dirname(__DIR__) . '/../components/template/modal.php');
    include(dirname(__DIR__) . '/../components/template/toast.php');
    ?>
    <main>
        <?php
        include(dirname(__DIR__) . '/../components/template/sidebar.php');
        ?>
        <section>
            <div>
                <div class="heading-container">
                    <!-- <button id="back-btn" class="material-symbols-outlined">
                        arrow_back
                    </button> -->
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
                    <?php if (!$lamaran_details): ?>
                        <?php if (!isset($user)): ?>
                            <a class="general-btn lamar-btn disabled" href="/jobs/<?= $id ?>/apply">
                                Lamar
                            </a>
                        <?php else: ?>
                            <a class="general-btn lamar-btn <?= $user['role'] == "company" ? "disabled" : "" ?>" href="/jobs/<?= $id ?>/apply">
                                Lamar
                            </a>
                        <?php endif; ?>
                </ul>
            <?php else: ?>
                <button class="general-btn applied-btn">
                    <span class="material-symbols-outlined">
                        check
                    </span>
                    <p>
                        Applied
                    </p>
                </button>
                <div class="applied-details">
                    <div class="applied-status">
                        <h2 class="applied-detail-heading">Status:
                            <span class="status 
                            <?php
                            if ($lamaran_details["status"] == "accepted") {
                                echo "accepted";
                            } else if ($lamaran_details["status"] == "rejected") {
                                echo "rejected";
                            } else {
                                echo "waiting";
                            }
                            ?>">
                                <?= ucfirst($lamaran_details["status"]) ?></span>
                        </h2>
                        <p><?= $lamaran_details["status_reason"] ?></p>
                        <h2 class="applied-detail-heading">Attachments:</h2>
                        <ul class="details-format attachment-list">
                            <li>
                                <a href="<?= $lamaran_details["cv_path"] ?>" target="_blank">
                                    <span class="material-symbols-outlined">
                                        description
                                    </span>
                                    <p><?= basename($lamaran_details["cv_path"]) ?></p>
                                </a>
                            </li>
                            <?php if ($lamaran_details["video_path"]): ?>
                                <li>
                                    <span class="material-symbols-outlined">
                                        videocam
                                    </span>
                                    <p><?= basename($lamaran_details["video_path"]) ?></p>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            </div>
            <div>
                <h1 class="lowongan-heading">About Company <?= $company_name ?></h1>
                <p><?= $company_about ?>
                </p>
            </div>
            <div>
                <h1 class="lowongan-heading">About This Job</h1>
                <p><?= $deskripsi ?></p>
            </div>
            <?php if ($attachments): ?>
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
        </section>
    <?php endif; ?>
    <?php if ($response):  ?>
        <?php if ($response['success']): ?>
            <?php toast("success", $response['message']); ?>
        <?php elseif (!$response['success']): ?>
            <?php toast("error", $response['message'], $response["errors"]); ?>
        <?php endif; ?>
    <?php endif; ?>
    </main>
</body>

<script src="/public/scripts/jobseeker/DetailLowongan.js"></script>
<script src="/public/scripts/template/navbar.js"></script>
<script src="/public/scripts/template/toast.js"></script>

</html>