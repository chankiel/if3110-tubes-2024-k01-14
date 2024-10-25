<aside>
    <div class="part-container">
        <div class="img-container">
            <img src="/public/images/bg-image-profile.png" alt="profile-picture" class="bg-image">
            <?php if (isset($user)): ?>
                <img src="/public/images/perry-casino.jpg" alt="profile-picture" class="img-logo">
            <?php else: ?>
                <img src="/public/images/question-mark.jpg" alt="profile-picture" class="img-logo">
            <?php endif; ?>
        </div>
        <div class="profile-container">
            <?php if (isset($user)): ?>

                <h1><?= $user['nama'] ?></h1>
                <h2><?= $user['email'] ?></h2>
            <?php else: ?>
                <h1>Guest</h1>
            <?php endif; ?>

        </div>
    </div>
    <?php if (isset($user) && $user["role"] === "company") : ?>
        <div class="part-container role-explanation">
            <h1 class="title-recent-applicants">Recent Applicants</h1>
            <ul class="recent-pelamar">
            <?php foreach($recentApplicants as $recentApplicant) { ?>
                <li class="data-recent-pelamar">
                    <a href="/applications/<?php echo htmlspecialchars($recentApplicant['idlamaran']) ?>">
                        <div class="applicant-info">
                            <h3><strong><?php echo htmlspecialchars($recentApplicant['nama']) ?></strong></h3>
                            <p><?php echo htmlspecialchars($recentApplicant['posisi'])?></p>
                            <small><?php echo htmlspecialchars($recentApplicant['lowongan_diffTime'])?> ago</small>
                        </div>
                        <span class="material-symbols-outlined" data-icon="arrow">
                            arrow_circle_right
                        </span>
                    </a>
                </li>
            <?php } ?>
            </ul>
        </div>
    <?php else : ?>
    <div class="part-container recomendation-container">
        <h1 class="recom-heading">Jobs Recomendation</h1>
        <ul>
            <?php foreach ($recommendations as $recommendation) :?>
                <li class="list-rec-jobs">
                    <div class="rec-list-container">
                        <p class="rec-posisi"><?=$recommendation["posisi"]?></p>
                        <p class="rec-jenis-pekerjaan"><?=$recommendation["jenis_pekerjaan"]?></p>
                        <div class="row blue">
                            <span class="material-symbols-outlined">
                            apartment
                            </span>
                            <p class="rec-company-name"><?=$recommendation["company_name"]?></p>
                        </div>
                        <div class="row">
                            <span class='material-symbols-outlined'>
                                location_on
                            </span>
                            <p class="rec-jenis-lokasi"><?=$recommendation["jenis_lokasi"]?></p>
                        </div>
                    </div>
                    <a href="/jobs/<?= $recommendation["id"]?>/details" class="rec-button">
                        <button class="see-button">
                            <span class="material-symbols-outlined">
                                arrow_circle_right
                            </span>
                        </button>
                    </a>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
    <?php endif; ?>
</aside>