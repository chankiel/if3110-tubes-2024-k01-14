<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/styles/general/home.css">
    <link rel="stylesheet" href="../../public/styles/template/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Jobs</title>
</head>

<body>
    <?php include(dirname(__DIR__) . '/../components/template/navbar.php') ?>

    <section>
        <div class="container">
            <aside class="left-sidebar">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search">
                    <i class="fa-solid fa-filter toggle-filter"></i>
                </div>
                <div class="filter-sort">
                    <div class="filter">
                        <h3>Filter</h3>
                        <div class="filter-location">
                            <p><strong>Lokasi</strong></p>
                            <form>
                                <label><input type="checkbox" name="fl-colour" value="on-site" /><span></span> On-site</label>
                                <label><input type="checkbox" name="fl-colour" value="remote" /><span></span> Remote</label>
                                <label><input type="checkbox" name="fl-colour" value="hybrid" /><span></span> Hybrid</label>
                            </form>
                        </div>
                        <div class="filter-jenis">
                            <p><strong>Jenis pekerjaan</strong></p>
                            <form>
                                <label><input type="checkbox" name="job-type" value="full-time" /><span></span> Full time</label>
                                <label><input type="checkbox" name="job-type" value="part-time" /><span></span> Part time</label>
                                <label><input type="checkbox" name="job-type" value="internship" /><span></span> Internship</label>
                            </form>
                        </div>
                    </div>
                    <div class="sort">
                        <p><strong>Waktu rilis</strong></p>
                        <form>
                            <label><input type="radio" id="terbaru" name="job_sort" value="terbaru" checked /><span></span> Terbaru</label>
                            <label><input type="radio" id="terlama" name="job_sort" value="terlama" /><span></span> Terlama</label>
                        </form>
                    </div>
                </div>
            </aside>


            <div class="main-content">
                <!-- <button class="add-job">
                    <i class="fa-solid fa-plus"></i>
                    Add job
                </button> -->

                <div class="show-jobs">
                    <div class="job-list">
                        <?php
                        $jobs = [
                            ["author" => "Google", "time" => "2 hours ago", "type" => "Full Time", "position" => "Software Engineer", "location" => "Remote", "details" => "More details"],
                            ["author" => "Microsoft", "time" => "3 hours ago", "type" => "Part Time", "position" => "Frontend Developer", "location" => "Remote", "details" => "More details"],
                            ["author" => "Amazon", "time" => "5 hours ago", "type" => "Full Time", "position" => "Operations Manager", "location" => "Seattle, WA", "details" => "More details"],
                            ["author" => "Apple", "time" => "1 hour ago", "type" => "Internship", "position" => "Data Analyst", "location" => "San Francisco, CA", "details" => "More details"],
                            ["author" => "Facebook", "time" => "4 hours ago", "type" => "Full Time", "position" => "Product Designer", "location" => "New York, NY", "details" => "More details"],
                            ["author" => "Tesla", "time" => "30 minutes ago", "type" => "Part Time", "position" => "Electrical Engineer", "location" => "Austin, TX", "details" => "More details"],
                            ["author" => "Netflix", "time" => "1 day ago", "type" => "Full Time", "position" => "Marketing Specialist", "location" => "Los Gatos, CA", "details" => "More details"]
                        ];

                        if (empty($jobs)): ?>
                            <div class="no-jobs">
                                <h2>No job listings available</h2>
                            </div>
                            <?php else:
                            foreach ($jobs as $job): ?>
                                <div class="job">
                                    <div class="job-author">
                                        <div class="author">
                                            <h1><?php echo $job['position']; ?></h1>
                                            <p><?php echo $job['type']; ?></p>
                                        </div>
                                    </div>
                                    <div class="job-info">
                                        <div class="job-type-location">
                                            <h2>
                                                <strong>
                                                    <a href="#" title="View Author Profile" class="company-name">
                                                        <?php echo $job['author']; ?>
                                                    </a>
                                                </strong>
                                            </h2>
                                            <div class="job-location">
                                                <i class="fa-solid fa-location-dot"></i>
                                                <p><?php echo $job['location']; ?></p>
                                            </div>
                                            <small><?php echo $job['time']; ?></small>
                                        </div>
                                    </div>
                                    <div class="job-details">
                                        <a href="#">More details</a>
                                    </div>
                                </div>
                        <?php endforeach;
                        endif; ?>
                    </div>

                    <?php if (!empty($jobs)): ?>
                        <div class="pagination"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        function getPageList(totalPages, page, maxLength) {
            function range(start, end) {
                return Array.from(Array(end - start + 1), (_, i) => i + start);
            }

            var sideWidth = maxLength < 9 ? 1 : 2;
            var leftWidth = (maxLength - sideWidth * 2 - 3) >> 1;
            var rightWidth = (maxLength - sideWidth * 2 - 3) >> 1;

            if (totalPages <= maxLength) {
                return range(1, totalPages);
            }

            if (page <= maxLength - sideWidth - 1 - rightWidth) {
                return range(1, maxLength - sideWidth - 1).concat(0, range(totalPages - sideWidth + 1, totalPages));
            }

            if (page >= totalPages - sideWidth - 1 - rightWidth) {
                return range(1, sideWidth).concat(0, range(totalPages - sideWidth - 1 - rightWidth - leftWidth, totalPages));
            }

            return range(1, sideWidth).concat(0, range(page - leftWidth, page + rightWidth), 0, range(totalPages - sideWidth + 1, totalPages));
        }

        $(function() {
            var numberOfItems = $(".job-list .job").length;
            if (numberOfItems > 0) {
                var limitPerPage = 2;
                var totalPages = Math.ceil(numberOfItems / limitPerPage);
                var paginationSize = 5;
                var currentPage;

                function showPage(whichPage) {
                    if (whichPage < 1 || whichPage > totalPages) return false;

                    currentPage = whichPage;

                    $(".job-list .job").hide().slice((currentPage - 1) * limitPerPage, currentPage * limitPerPage).show();

                    $(".pagination li").slice(1, -1).remove();

                    getPageList(totalPages, currentPage, paginationSize).forEach(item => {
                        $("<li>").addClass("page-item").addClass(item ? "current-page" : "dots")
                            .toggleClass("active", item === currentPage).append($("<a>").addClass("page-link")
                                .attr({
                                    href: "javascript:void(0)"
                                }).text(item || "...")).insertBefore(".next-page");
                    });

                    $(".previous-page").toggleClass("disable", currentPage === 1);
                    $(".next-page").toggleClass("disable", currentPage === totalPages);

                    return true;
                }

                $(".pagination").append(
                    $("<li>").addClass("page-item").addClass("previous-page").append($("<a>").addClass("page-link").attr({
                        href: "javascript:void(0)"
                    }).text("Prev")),
                    $("<li>").addClass("page-item").addClass("next-page").append($("<a>").addClass("page-link").attr({
                        href: "javascript:void(0)"
                    }).text("Next")),
                );

                $(".job-list").show();
                showPage(1);

                $(document).on("click", ".pagination li.current-page:not(.active)", function() {
                    return showPage(+$(this).text());
                });

                $(".next-page").on("click", function() {
                    return showPage(currentPage + 1);
                });

                $(".previous-page").on("click", function() {
                    return showPage(currentPage - 1);
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".toggle-filter").on("click", function() {
                $(".filter-sort").toggle();
            });
        });
    </script>
</body>

</html>