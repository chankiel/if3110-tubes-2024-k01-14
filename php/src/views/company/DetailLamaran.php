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
    <link rel="stylesheet" href="/public/styles/company/DetailLamaran.css">
</head>

<body>
    <?php
    include(dirname(__DIR__) . '/../components/template/navbar.php');
    include(dirname(__DIR__) . '/../components/template/modal.php')
    ?>
    <main>
        <section>
            <div class="heading-container">
                <h1 class="position-heading">
                    <?= $nama ?>
                </h1>
                <p><?= $email ?></p>
            </div>

        <div class="attachments">
            <div class="cv-section">
                <h3>CV</h3>
                <embed src="<?php echo htmlspecialchars($cv_path); ?>" type="application/pdf" width="100%" height="400px" />
            </div>
            <div class="video-section">
                <h3>Introduction Video (if any)</h3>
                <?php if (!empty($video_path)): ?>
                    <video controls width="100%">
                        <source src="<?php echo htmlspecialchars($video_path); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php else: ?>
                    <p>No video provided.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="applied-details">
            <div class="applied-status">
                <h2 class="applied-detail-heading">Status:
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
                <p><?= $status_reason ?></p>
            </div>
        </div>

        <?php if ($status == 'waiting'): ?>
        <div class="approval-section">
            <h2>Company Actions</h2>
            <form action="/applications/<?= $lowongan_id ?>/approve" method="post">
                <input type="hidden" name="app_id" value="<?php echo htmlspecialchars($app_id); ?>">
                <div class="action-buttons">
                    <button type="submit" name="action" value="approve" class="approve-btn">Approve</button>
                    <button type="submit" name="action" value="reject" class="reject-btn">Reject</button>
                </div>
                <div class="rich-text-editor">
                    <h3>Reason/Follow-up</h3>
                    <textarea name="follow_up" rows="6" placeholder="Enter reason or follow-up here..." ></textarea>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <?php if($response):?>
            <?php if ($response['success']): ?>
                <?php modal("success",$response['message']); ?>
            <?php elseif(!$response['success']): ?>
                <?php modal("error",$response['message'],$response["errors"]); ?>
            <?php endif; ?>
        <?php endif; ?>
    </main>
</body>

<script src="/public/scripts/company/DetailLowongan.js"></script>

</html>