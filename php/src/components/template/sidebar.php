<aside>
    <div class="part-container">
        <div class="img-container">
            <img src="/public/images/bg-image-profile.png" alt="profile-picture" class="bg-image">
            <?php if (isset($user)): ?>
                <img src="/public/images/perry-casino.webp" alt="profile-picture" class="img-logo">
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
            <?php if (!empty($recentApplicants)) : ?>
                <ul class="recent-pelamar">
                    <?php foreach($recentApplicants as $recentApplicant) :?>
                        <li class="data-recent-pelamar">
                            <a href="/applications/<?php echo htmlspecialchars($recentApplicant['idlamaran']) ?>">
                                <div class="applicant-info">
                                    <h3><strong class="subjudul-sidebar"><?php echo htmlspecialchars($recentApplicant['nama']) ?></strong></h3>
                                    <p><?php echo htmlspecialchars($recentApplicant['posisi'])?></p>
                                    <small><?php echo htmlspecialchars($recentApplicant['lowongan_diffTime'])?> ago</small>
                                </div>
                                <span class="material-symbols-outlined" data-icon="arrow">
                                    arrow_circle_right
                                </span>
                            </a>
                        </li>
                    <?php endforeach;?>
                </ul>
            <?php else: ?>
                <p class="no-recommendations">No applicants at the moment</p>
            <?php endif; ?>
        </div>
    <?php else : ?>
        <div class="part-container recomendation-container">
            <h1 class="title-recent-applicants">Jobs Recomendation</h1>
            <?php if (!empty($recommendations)) : ?>
                <ul class="recent-pelamar">
                    <?php foreach ($recommendations as $recommendation) :?>
                        <li class="data-recent-pelamar">
                            <a href="/jobs/<?php echo htmlspecialchars($recommendation["id"]) ?>/details">
                                <div class="applicant-info">
                                    <h1><strong class="subjudul-sidebar"><?php echo htmlspecialchars($recommendation["posisi"]) ?></strong></h3>
                                    <h2><?php echo htmlspecialchars($recommendation["company_name"])?></h5>
                                    <p><?php echo htmlspecialchars($recommendation["jenis_pekerjaan"])?></p>
                                    <p><?php echo htmlspecialchars($recommendation["jenis_lokasi"])?></p>
                                </div>
                                <span class="material-symbols-outlined" data-icon="arrow">
                                    arrow_circle_right
                                </span>
                            </a>
                        </li>
                    <?php endforeach;?>
                </ul>
            <?php else: ?>
                <p class="no-recommendations">No job recommendations available at the moment</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</aside>