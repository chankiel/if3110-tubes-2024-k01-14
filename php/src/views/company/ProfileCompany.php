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
    <link rel="stylesheet" href="/public/styles/company/ProfileCompany.css">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
</head>

<body>
    <?php
    include(dirname(__DIR__) . '/../components/template/navbar.php');
    include(dirname(__DIR__) . '/../components/template/modal.php')
    ?>
    <main>
        <div class="img-container">
            <img src="/public/images/bg-image-profile.png" alt="profile-picture" class="bg-image">
            <img src="/public/images/linkedin.png" alt="profile-picture" class="img-logo">
        </div>
        <section class="edit-container">
            <form action="" class="profile-form">
                <div class="input-area normal-state" id="input-nama">
                    <label for="nama">Nama*</label>
                    <input type="text" id="nama" name="nama" value="<?= $company_name['nama'] ?>">
                    <p class="error-details hidden err-nama">Nama tidak boleh kosong!</p>
                </div>
                <div class="input-area normal-state" id="input-lokasi">
                    <label for="lokasi">Lokasi*</label>
                    <input type="text" id="lokasi" name="lokasi" value="<?= $lokasi ?>">
                    <p class="error-details hidden err-lokasi">Lokasi tidak boleh kosong!</p>
                </div>
                <div class="quil-container" id="input-about">
                    <label for="quill-editor">About Company</label>
                    <div id="quill-editor">
                        <?= $about ?>
                    </div>
                    <textarea name="about" id="hiddenArea"></textarea>
                </div>
                <p class="error-details hidden err-about">About Company tidak boleh kosong!</p>
                <p class="required-ctt">*required</p>
                <button type="submit" class="submit-btn">Simpan</button>
            </form>
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
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="../public/scripts/ProfileCompany.js"></script>

</html>