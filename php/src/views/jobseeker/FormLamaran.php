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
    <link rel="stylesheet" href="/public/styles/jobseeker/FormLamaran.css">
</head>

<body>
    <?php include(dirname(__DIR__) . '/../components/template/navbar.php') ?>
    <main>
        <?php
        include(dirname(__DIR__) . '/../components/template/sidebar.php');
        ?>
        <section class="edit-container">
            <div class="heading-container">
                <button id="back-btn" class="material-symbols-outlined hidden">
                    arrow_back
                </button>
                <h1 class="h1-lamaran">
                    Application Form
                </h1>
            </div>
            <h2 class="h2-lamaran"><?= $posisi ?> Position at <?= $company_name ?></h2>
            <div class="job-detail">
                <span class="material-symbols-outlined">
                    work
                </span>
                <p><?= $jenis_pekerjaan ?></p>
            </div>
            <div class="job-detail">
                <span class="material-symbols-outlined">
                    location_on
                </span>
                <p><?= $jenis_lokasi ?></p>
            </div>
            <p class="job-desc ">
                Please ensure all mandatory fields are completed accurately to avoid delays in processing your application.</p>
            <form action="/jobs/<?= $lowongan_id ?>/apply" method="POST" class="apply-form" enctype="multipart/form-data">
                <div class="input-area ">
                    <label for="cv"><em>Curriculum Vitae</em> (CV)*</label>
                    <input type="file" id="cv" name="cv" accept=".pdf,.docx">
                    <p class="error-details hidden">CV cannot be empty!</p>
                </div>
                <div class="input-area">
                    <label for="video">Video Perkenalan</label>
                    <input type="file" id="video" name="video" accept=".mp4">
                </div>
                <p class="required-ctt">*required</p>
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </section>
    </main>
</body>
<script src="/public/scripts/jobseeker/FormLamaran.js"></script>
<script src="/public/scripts/template/navbar.js"></script>

</html>