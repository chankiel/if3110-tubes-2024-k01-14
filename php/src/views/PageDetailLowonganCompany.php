<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tambah lowongan</title>
    <!-- <link rel="stylesheet" href="../public/styles/style.css">
    <link rel="stylesheet" href="../public/styles/template/navbar.css"> -->
</head>
<body>
    <h1>WBD LABPRO</h1>
    <!-- <form action="../index.php?action=login" method="POST"></form> -->
    
    <form action="../controllers/LowonganController.php" method="POST">
        <label for="posisi">posisi</label>
        <input type="text" name="posisi" required>

        <label for="deskripsi">deskripsi</label>
        <input type="text" name="deskripsi" required>

        <label for="jenis_pekerjaan">Jenis Pekerjaan</label>
        <select id="jenis_pekerjaan" name="jenis_pekerjaan">
            <option value="Internship">Internship</option>
            <option value="Part-time">Part-time</option>
            <option value="Full-time">Full-time</option>
        </select>

        <label for="jenis_lokasi">Jenis Pekerjaan</label>
        <select id="jenis_lokasi" name="jenis_lokasi">
            <option value="on-site">On-site</option>
            <option value="hybrid">Hybrid</option>
            <option value="remote">Remote</option>
        </select>

        <button type="submit">Tambah Lowongan</button>

        <!-- <div class="redirect-login">
            <p>New to LinkedIn? <a href="Register.php">Join now</a></p>
        </div> -->
    </form>
</body>
</html>