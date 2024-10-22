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
    <title>Edit lowongan</title>
    <link rel="stylesheet" href="../../public/styles/company/EditLowongan.css">
    <link rel="stylesheet" href="../../public/styles/template/navbar.css">
    <link rel="stylesheet" href="../../public/styles/template/modal.css">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />

</head>

<body>
    <?php
    include(dirname(__DIR__) . '/../components/template/navbar.php');
    include(dirname(__DIR__) . '/../components/template/modal.php')
    ?>
    <main>
        <section class="form-edit-lowongan">
            <form action="/jobs" method="POST" enctype="multipart/form-data">
                <label for="posisi">Posisi</label>
                <input type="text" name="posisi">

                <label for="deskripsi">Deskripsi</label>
                <div id="deskripsi">
                </div>
                <textarea name="deskripsi" id="hiddenArea"></textarea>

                <label for="jenis_pekerjaan">Jenis Pekerjaan</label>
                <select id="jenis_pekerjaan" name="jenis_pekerjaan">
                    <option selected disabled></option>
                    <option value="Full-time">Full-time</option>
                    <option value="Part-time">Part-time</option>
                    <option value="Internship">Internship</option>
                </select>

                <label for="jenis_lokasi">Jenis Lokasi</label>
                <select id="jenis_lokasi" name="jenis_lokasi">
                    <option selected disabled></option>
                    <option value="On-site">On-site</option>
                    <option value="Hybrid">Hybrid</option>
                    <option value="Remote">Remote</option>
                </select>

                <div class="input-area ">
                    <label for="cv">Attachments</label>
                    <input type="file" id="files" name="files[]" accept=".jpeg, .png .jpg" multiple>
                    <div id="image-preview">
                    </div>
                </div>

                <button type="submit">Simpan Perubahan</button>
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
<script src="/public/scripts/template/modal.js"></script>
<script src="/public/scripts/company/EditLowongan.js"></script>

</html>