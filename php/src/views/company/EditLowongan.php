<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit lowongan</title>
    <link rel="stylesheet" href="../../public/styles/company/EditLowongan.css">
    <link rel="stylesheet" href="../../public/styles/template/navbar.css">
    <link rel="stylesheet" href="../../public/styles/template/modal.css">

</head>
<body>
    <?php
    include(dirname(__DIR__) . '/../components/template/navbar.php');
    include(dirname(__DIR__) . '/../components/template/modal.php')
    ?>
    <main>
        <h1>Halaman Edit</h1>
        <div class="form-edit-lowongan">
            <form action="/jobs/<?=$id?>" method="POST">
                <label for="posisi">Posisi</label>
                <input type="text" name="posisi" placeholder="<?=$posisi?>">
                
                <label for="deskripsi">Deskripsi</label>
                <input type="text" name="deskripsi" placeholder="<?=$deskripsi?>">
                
                <label for="jenis_pekerjaan">Jenis Pekerjaan</label>
                <select id="jenis_pekerjaan" name="jenis_pekerjaan">
                    <option selected disabled value="default"><?=$jenis_pekerjaan?></option>
                    <option value="Full-time">Full-time</option>
                    <option value="Part-time">Part-time</option>
                    <option value="Internship">Internship</option>
                </select>
        
                <label for="jenis_lokasi">Jenis Lokasi</label>
                <select id="jenis_lokasi" name="jenis_lokasi">
                    <option selected disabled value="default"><?=$jenis_lokasi?></option>
                    <option value="on-site">On-site</option>
                    <option value="hybrid">Hybrid</option>
                    <option value="remote">Remote</option>
                </select>

                <div class="input-area ">
                    <label for="cv">Gambar Pendukung</label>
                    <input type="file" id="cv" name="cv" accept="*.jpeg, *.png *.jpg">
                </div>
                
                <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
    </main>
</body>
</html>