<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=home" />
    <link rel="stylesheet" href="../public/styles/style.css">
    <link rel="stylesheet" href="../public/styles/template/navbar.css">
    <link rel="stylesheet" href="../public/styles/company/ProfileCompany.css">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
</head>

<body>
    <?php include(dirname(__DIR__) . '/components/template/navbar.php') ?>
    <main>
        <div class="img-container">
            <div class="img-logo"><p>I</p></div>
            <div>

            </div>
        </div>
        <section class="edit-container">
            <form action="">
                <div class="input-area normal-state">
                    <label for="nama">Nama*</label>
                    <input type="text" id="nama" name="nama" value="Bu Fazat">
                </div>
                <div class="input-area error-state">
                    <label for="lokasi">Lokasi*</label>
                    <input type="text" id="lokasi" name="lokasi" value="Hehehe">
                    <p class="error-details">Location cannot be empty!</p>
                </div>
                <div class="quil-container">
                    <label for="quill-editor">About Company</label>
                    <div id="quill-editor">

                    </div>
                </div>
                <textarea name="about" id="hiddenArea"></textarea>
                <p class="required-ctt">*required</p>
                <button type="submit" class="">Simpan</button>
            </form>
        </section>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

<script>
    const quill = new Quill('#quill-editor', {
        theme: 'snow'
    });

    const textarea = document.querySelector('#hiddenArea');
    const form = document.querySelector("form");
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        textarea.value = quill.root.innerHTML;
    })
</script>

</html>