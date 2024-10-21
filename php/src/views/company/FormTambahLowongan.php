<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah lowongan</title>
    <link rel="stylesheet" href="../public/styles/company/TambahLowongan.css">
    <link rel="stylesheet" href="../public/styles/template/navbar.css">
    <link rel="stylesheet" href="../public/styles/template/modal.css">

</head>
<body>
    <?php
    include(dirname(__DIR__) . '/../components/template/navbar.php');
    include(dirname(__DIR__) . '/../components/template/modal.php')
    ?>
    <main>
        <h1>Tambah Lowongan</h1>
        <div class="form-tambah-lowongan">
            <form action="/jobs" method="POST">
                <label for="posisi">Posisi</label>
                <input type="text" name="posisi" required>
                
                <label for="deskripsi">Deskripsi</label>
                <input type="text" name="deskripsi" required>
                
                <label for="jenis_pekerjaan">Jenis Pekerjaan</label>
                <select id="jenis_pekerjaan" name="jenis_pekerjaan">
                    <option value="Full-time">Full-time</option>
                    <option value="Part-time">Part-time</option>
                    <option value="Internship">Internship</option>
                </select>
        
                <label for="jenis_lokasi">Jenis Pekerjaan</label>
                <select id="jenis_lokasi" name="jenis_lokasi">
                    <option value="on-site">On-site</option>
                    <option value="hybrid">Hybrid</option>
                    <option value="remote">Remote</option>
                </select>

                <div class="input-area ">
                    <label for="cv">Gambar Pendukung</label>
                    <input type="file" id="cv" name="cv" accept=".jpeg, .png. jpg">
                </div>
                
                <button type="submit">Tambah Lowongan</button>
        </form>
    </div>
    </main>
</body>
</html>
