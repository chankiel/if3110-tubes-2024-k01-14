<div class="job">
    <div class="job-author">
        <div class="author">
            <h1><?php echo htmlspecialchars($job['posisi']); ?></h1>
            <p><?php echo htmlspecialchars($job['jenis_pekerjaan']); ?></p>
        </div>
    </div>
    <div class="job-info">
        <div class="job-type-location">
            <h2>
                <strong>
                    <a href="#" title="View Author Profile" class="company-name">
                        <?php echo htmlspecialchars($job['nama']); ?>
                    </a>
                </strong>
            </h2>
            <div class="job-location">
                <i class="fa-solid fa-location-dot"></i>
                <p><?php echo htmlspecialchars($job['jenis_lokasi']); ?></p>
            </div>
            <small><?php echo htmlspecialchars($job['lowongan_diffTime']); ?></small>
        </div>
    </div>
    <div class="job-details">
        <a href="#">More details</a>
    </div>
</div>
