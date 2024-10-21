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
    <link rel="stylesheet" href="/public/styles/company/DetailLowongan.css">
</head>

<body>
    <?php
    include(dirname(__DIR__) . '/../components/template/navbar.php');
    include(dirname(__DIR__) . '/../components/template/modal.php')
    ?>
    <main>
        <section>
            <div class="heading-container">
                <!-- <button id="back-btn" class="material-symbols-outlined">
                    arrow_back
                </button> -->
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
                <?php if (!$lamaran_details): ?>
                    <a class="general-btn lamar-btn" href="/jobs/<?= $id ?>/apply">
                        Lamar
                    </a>
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
        </section>
        <section>
            <h1 class="lowongan-heading">Tentang <?= $company_name ?></h1>
            <p><?= $company_about ?>
            </p>
        </section>
        <section>
            <h1 class="lowongan-heading">Tentang Pekerjaan Ini</h1>
            <p><?= $deskripsi ?></p>
        </section>
        <?php if($response):?>
            <?php if ($response['success']): ?>
                <?php modal("success",$response['message']); ?>
            <?php elseif(!$response['success']): ?>
                <?php modal("error",$response['message'],$response["errors"]); ?>
            <?php endif; ?>
        <?php endif; ?>
    </main>
</body>

<script src="/public/scripts/company/DetailLowongan.js"></script>

</html>