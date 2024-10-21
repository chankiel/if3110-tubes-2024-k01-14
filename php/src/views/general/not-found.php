<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="/public/styles/style.css">
    <link rel="stylesheet" href="/public/styles/template/navbar.css">
    <link rel="stylesheet" href="/public/styles/general/not-found.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <?php include(dirname(__DIR__) . '/../components/template/navbar.php') ?>
    <main>
        <section>
            <h1 class="desc">
                The page you're looking for doesn't exist
            </h1>
            <button class="back-btn">
                Go Back
            </button>
        </section>
    </main>
</body>
<script src="/public/scripts/general/not-found.js"></script>

</html>