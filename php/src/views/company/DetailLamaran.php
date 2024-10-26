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
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="/public/styles/style.css">
    <link rel="stylesheet" href="/public/styles/template/navbar.css">
    <link rel="stylesheet" href="/public/styles/template/sidebar.css">
    <link rel="stylesheet" href="/public/styles/template/modal.css">
    <link rel="stylesheet" href="/public/styles/template/toast.css">
    <link rel="stylesheet" href="/public/styles/company/DetailLamaran.css">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />

</head>

<body>
    <?php
    include(dirname(__DIR__) . '/../components/template/navbar.php');
    include(dirname(__DIR__) . '/../components/template/modal.php');
    include(dirname(__DIR__) . '/../components/template/toast.php')
    ?>
    <main>
        <?php
        include(dirname(__DIR__) . '/../components/template/sidebar.php')
        ?>
        <section>
            <div class="heading-container">
                <h1 class="name-heading">
                    <?= $nama ?>
                </h1>
                <p><?= $email ?></p>
                <h2 class="lowongan-link">Applied for <a href="/jobs/<?= $lowongan_id?>">this</a> job</h2>
            </div>

            <div class="attachments">
                <h2 class="section-heading">Application Attachments</h2>
                <div class="cv-section">
                    <h3><em>Curriculum Vitae</em> (<a href="<?= $cv_path ?>" download>Download</a>)</h3>
                    <embed src="<?php echo htmlspecialchars($cv_path); ?>" type="application/pdf" />
                </div>
                <div class="video-section">
                    <h3>Introduction Video
                        <?php if (!empty($video_path)): ?>
                            (<a href="<?= $video_path ?>" download="">Download</a>)
                        <?php endif; ?>
                    </h3>
                    <?php if (!empty($video_path)): ?>
                        <video controls width="100%">
                            <source src="<?php echo htmlspecialchars($video_path); ?>" type="video/mp4">
                            <p class="fail-attachment">Your browser does not support the video tag. Link video <a href="<?= $video_path ?>">here</a></p>
                        </video>
                    <?php else: ?>
                        <p class="fail-attachment">No video provided.</p>
                    <?php endif; ?>
                </div>
            </div>

            <input type="hidden" id="status" value="<?php echo htmlspecialchars($status); ?>">
            <?php if ($status !== 'waiting'): ?>
                <div class="applied-details">
                    <div class="applied-status">
                        <h2 class="section-heading">Status:
                            <span class="status 
                    <?php
                    if ($status == "accepted") {
                        echo "accepted";
                    } else if ($status == "rejected") {
                        echo "rejected";
                    } else {
                        echo "waiting";
                    }
                    ?>">
                                <?= ucfirst($status) ?></span>
                        </h2>
                        <h1 class="status-reason-heading">Status Reason:</h1>
                        <div class="status-reason"><?= $status_reason ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($status == 'waiting'): ?>
                <div class="approval-section">
                    <h2 class="section-heading">Job Approval</h2>
                    <div class="approval-div-input">
                        <input type="hidden" id="lamaran_id" value="<?php echo htmlspecialchars($id); ?>">
                        <div class="approval-buttons">
                            <!-- <form action="/applications//approve" class="approve-form">
                                <button type="submit" name="action" value="approve" class="approve-btn">Approve</button>
                                <textarea name="status_reason" id="approve-input"></textarea>
                            </form> -->
                            <button class="approve-btn" id="approve-trigger">Approve</button>
                            <button class="reject-btn" id="reject-trigger">Reject</button>

                            <!-- <form action="/applications//reject" class="reject-form">
                                <button type="submit" name="action" value="approve" class="reject-btn">Reject</button>
                                <textarea name="status_reason" id="reject-input"></textarea>
                            </form> -->
                        </div>
                        <div class="rich-text-editor">
                            <label for="status_reason">Reason / Follow-up</label>
                            <div id="status_reason">
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($response): ?>
                <?php if ($response['success']): ?>
                    <?php toast("success", $response['message']); ?>
                <?php elseif (!$response['success']): ?>
                    <?php toast("error", $response['message'], $response["errors"]); ?>
                <?php endif; ?>
            <?php endif; ?>

            <?php modal(
                "approve",
                "Approve Applicant",
                "Are you sure you want to approve this applicant? By approving, you confirm that the applicant is suitable for this position",
                "/applications/<?= $lowongan_id ?>/approve",
                "Approve",
                "status_reason",
                "approve-input"
            ); ?>

            <?php modal(
                "reject",
                "Reject Applicant",
                "Are you sure you want to reject this applicant? Once rejected, the applicant will be informed of your decision",
                "/applications/<?= $lowongan_id ?>/reject",
                "Reject",
                "status_reason",
                "reject-input"
            ); ?>
        </section>
    </main>
</body>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="/public/scripts/template/modal.js"></script>
<script src="/public/scripts/template/navbar.js"></script>
<script src="/public/scripts/template/toast.js"></script>
<script src="/public/scripts/company/DetailLamaran.js"></script>



</html>