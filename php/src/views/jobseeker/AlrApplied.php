<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="/public/styles/style.css">
    <link rel="stylesheet" href="/public/styles/template/navbar.css">
    <link rel="stylesheet" href="/public/styles/jobseeker/AlrApplied.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <?php include(dirname(__DIR__) . '/../components/template/navbar.php') ?>
    <main>
        <section>
            <h1 class="desc">
                You already applied for this job..
            </h1>
            <h2>
                Applied <span class="diffTime"><?= $lamaran_diffTime ?></span> ago
            </h2>
            <div class="attachments-container">
                <h3>
                    Attachments:
                </h3>
                <ul class="attachment-list">
                    <li>
                        <a href="<?= $cv_path ?>" target="_blank">
                            <span class="material-symbols-outlined">
                                description
                            </span>
                            <p><?= basename($cv_path) ?></p>
                        </a>
                    </li>
                    <?php if ($video_path): ?>
                        <li>
                            <a href="<?= $video_path ?>" target="_blank">

                                <span class="material-symbols-outlined">
                                    videocam
                                </span>
                                <p><?= basename($video_path) ?></p>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <button class="back-btn">
                Go Back
            </button>
        </section>
    </main>
</body>
<script src="/public/scripts/general/not-found.js"></script>
<script src="/public/scripts/template/navbar.js"></script>

</html>