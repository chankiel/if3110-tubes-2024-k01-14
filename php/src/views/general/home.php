<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Show Jobseeker home page">
    <link rel="stylesheet" href="../../public/styles/home/home.css">
    <link rel="stylesheet" href="../../public/styles/template/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Home</title>
</head>
<body>

    <?php include dirname(__DIR__) . '/../components/template/navbar.php' ?>
    
    <section>
        <div class="container">
            <aside class="left-sidebar">
                <?php include dirname(__DIR__) . '/../components/home/searchBox.php' ?>
                <?php include dirname(__DIR__) . '/../components/home/filterSort.php' ?>
            </aside>
            <div class="main-content">
                <?php if (isset($_COOKIE["role"]) && $_COOKIE["role"] === "company"): ?>
                    <?php include dirname(__DIR__) . '/../components/home/addJob.php'; ?>
                <?php endif; ?>

                <?php include dirname(__DIR__) . '/../components/home/showJobs.php' ?>
            </div>
        </div>
    </section>

    <script src = "../../public/scripts/home/home.js"></script>
</body>
</html>