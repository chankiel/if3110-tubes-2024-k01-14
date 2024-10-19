<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="/public/styles/style.css">
    <link rel="stylesheet" href="/public/styles/template/navbar.css">
    <link rel="stylesheet" href="/public/styles/company/DetailLowongan.css">
</head>

<body>
    <?php include(dirname(__DIR__) . '/components/template/navbar.php') ?>
    <main>
        <section>
            <div class="heading-container">
                <button id="back-btn" class="material-symbols-outlined">
                    arrow_back
                </button>
                <p>Agoda</p>
                <h1 class="position-heading">
                    Senior Software Engineer
                </h1>
            </div>
            <p class="small-details">Bandung, Jawa Barat, Indonesia · Diposting 2 minggu lalu</p>
            <ul class="lowongan-details details-format">
                <li>
                    <span class="material-symbols-outlined">
                        person
                    </span>
                    <p>Software Engineer</p>
                </li>
                <li>
                    <span class="material-symbols-outlined">
                        work
                    </span>
                    <p>Jenis pekerjaan</p>
                </li>
                <li>
                    <span class="material-symbols-outlined">
                        location_on
                    </span>
                    <p>On-Site</p>
                </li>
                <?php if (true): ?>
                    <button class="general-btn lamar-btn">
                        Lamar
                    </button>
            </ul>
            <?php else: ?>
                <button class="general-btn applied-btn">
                    <span class="material-symbols-outlined">
                        check
                    </span>
                    <p>
                        Applied
                    </p>
                </button>
                <div class="applied-details">
                    <div class="applied-status">
                        <h2 class="applied-detail-heading">Status: <span class="status">Accepted</span></h2>
                        <p>Selamat! Anda diterima karena ganteng! Silahkan menghubungi saya di 0822124124142</p>
                        <h2 class="applied-detail-heading">Attachments:</h2>
                        <ul class="details-format attachment-list">
                            <li>
                                <span class="material-symbols-outlined">
                                    videocam
                                </span>
                                <p>KielPerkenalan.mp4</p>
                            </li>
                            <li>
                                <span class="material-symbols-outlined">
                                    description
                                </span>
                                <p>KielCV.pdf</p>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endif ?>
        </section>
        <section>
            <h1 class="lowongan-heading">Tentang Agoda</h1>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Labore suscipit ut, nobis enim aliquam laudantium aut magnam fugiat, error iure laborum temporibus dolorem, eveniet impedit dignissimos! Dolorem atque ad repudiandae? <br>
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Recusandae illum magnam placeat? Corrupti maiores cumque impedit praesentium, inventore, a doloremque porro molestiae molestias aut earum itaque reprehenderit at laudantium eius?
            </p>
        </section>
        <section>
            <h1 class="lowongan-heading">Tentang Pekerjaan Ini</h1>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Obcaecati eius sapiente hic temporibus illum maiores itaque maxime atque, at quos est, soluta voluptate ipsum nulla similique, pariatur dolor dignissimos incidunt.</p>
        </section>
    </main>
</body>

</html>