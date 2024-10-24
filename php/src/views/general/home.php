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
    <meta name="description" content="Show Jobseeker home page">
    <link rel="stylesheet" href="../../public/styles/home/home.css">
    <link rel="stylesheet" href="../../public/styles/template/navbar.css">
    <link rel="stylesheet" href="../../public/styles/template/sidebar.css">
    <link rel="stylesheet" href="../../public/styles/template/toast.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Home</title>
</head>

<body>

    <?php include dirname(__DIR__) . '/../components/template/navbar.php' ?>

    <section>
        <div class="container">
            <?php include dirname(__DIR__) . '/../components/template/sidebar.php' ?>
            <div class="main-content">
                <?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "company"): ?>
                    <?php include dirname(__DIR__) . '/../components/home/addJob.php'; ?>
                <?php endif; ?>

                <?php include dirname(__DIR__) . '/../components/home/showJobs.php' ?>
            </div>
            <aside class="left-sidebar">
                <?php include dirname(__DIR__) . '/../components/home/searchBox.php' ?>
                <?php include dirname(__DIR__) . '/../components/home/filterSort.php' ?>
            </aside>
        </div>
    </section>
    <?php if ($response): ?>
        <?php if ($response['success']): ?>
            <?php toast("success", $response['message']); ?>
        <?php elseif (!$response['success']): ?>
            <?php toast("error", $response['message'], $response["errors"]); ?>
        <?php endif; ?>
    <?php endif; ?>
</body>
<script src="/public/scripts/home/home.js"></script>
<script src="/public/scripts/template/navbar.js"></script>
<script src="/public/scripts/template/toast.js"></script>

</html>