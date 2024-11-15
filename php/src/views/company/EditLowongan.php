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
    <title>Edit lowongan</title>
    <link rel="stylesheet" href="../../public/styles/company/FormLowongan.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="../../public/styles/style.css">
    <link rel="stylesheet" href="../../public/styles/template/navbar.css">
    <link rel="stylesheet" href="../../public/styles/template/sidebar.css">
    <link rel="stylesheet" href="../../public/styles/template/modal.css">
    <link rel="stylesheet" href="../../public/styles/template/toast.css">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />

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
        <section class="form-lowongan">
            <h1>Edit Your Job to Match Your Needs</h1>
            <form action="/jobs/<?= $id ?>" method="POST" enctype="multipart/form-data" id="form-lowongan" data-mode='edit'>
                <div class="input-area normal-state" id="div-posisi">

                    <label for="posisi">Position*</label>
                    <input type="text" name="posisi" id="posisi" value="<?= $posisi ?>">
                    <p class="error-details hidden hidden err-posisi">Position cant't be empty!</p>
                </div>
                <div class="input-area normal-state" id="div-deskripsi">
                    <label for="deskripsi">Job Description*</label>
                    <div id="quil-deskripsi">
                    <?= $deskripsi ?>
                    </div>
                    <textarea name="deskripsi" id="deskripsi"></textarea>
                    <p class="error-details hidden hidden err-deskripsi">Job Description cant't be empty!</p>
                </div>

                <div class="input-area normal-state" id="div-pekerjaan">
                    <label for="jenis_pekerjaan">Job Type*</label>
                    <select id="jenis_pekerjaan" name="jenis_pekerjaan">
                        <option selected disabled><?= $jenis_pekerjaan ?></option>
                        <option value="Full-time">Full-time</option>
                        <option value="Part-time">Part-time</option>
                        <option value="Internship">Internship</option>
                    </select>
                    <p class="error-details hidden hidden err-pekerjaan">Job Type cant't be empty!</p>
                </div>

                <div class="input-area normal-state" id="div-lokasi">
                    <label for="jenis_lokasi">Location Type*</label>
                    <select id="jenis_lokasi" name="jenis_lokasi">
                        <option selected disabled><?= $jenis_lokasi ?></option>
                        <option value="On-site">On-site</option>
                        <option value="Hybrid">Hybrid</option>
                        <option value="Remote">Remote</option>
                    </select>
                    <p class="error-details hidden hidden err-lokasi">Location Type cant't be empty!</p>
                </div>

                <div class="input-area normal-state" id="div-attachments">
                    <label for="files">Attachments</label>
                    <input type="file" id="files" name="files[]" accept="image/*" multiple>
                    <div id="preview-container">
                    </div>
                </div>

                <button type="submit" class="submit-btn">Submit Job</button>
            </form>
        </section>
        <?php if ($response): ?>
            <?php if ($response['success']): ?>
                <?php toast("success", $response['message']); ?>
            <?php elseif (!$response['success']): ?>
                <?php toast("error", $response['message'], $response["errors"]); ?>
            <?php endif; ?>
        <?php endif; ?>
    </main>
</body>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="/public/scripts/template/modal.js"></script>
<script src="/public/scripts/general/form.js"></script>
<script src="/public/scripts/company/FormLowongan.js"></script>
<script src="/public/scripts/template/navbar.js"></script>
<script src="/public/scripts/template/toast.js"></script>

</html>