<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="/public/styles/style.css">
    <link rel="stylesheet" href="/public/styles/template/navbar.css">
    <link rel="stylesheet" href="/public/styles/jobseeker/FormLamaran.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <?php include(dirname(__DIR__) . '/components/template/navbar.php') ?>
    <main>
        <section class="edit-container">
            <div class="heading-container container">
                <button id="back-btn" class="material-symbols-outlined hidden">
                    arrow_back
                </button>
                <h1 class="h1-lamaran">
                    Application Form
                </h1>
            </div>
            <h2 class="h2-lamaran container">for Software Engineering Position at Google</h2>
            <p class="job-desc container">Thank you for your interest in joining our team.
                Please ensure all mandatory fields are completed accurately to avoid delays in processing your application.</p>
            <form action="" class="container apply-form">
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
<script src="/public/scripts/FormLamaran.js"></script>

</html>