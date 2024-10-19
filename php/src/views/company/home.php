<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "../../public/styles/general/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <nav class = "navbar">
        <div class="navbar-left">
            <a href = "home.html" class = "logo">
            </a>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type = "text" placeholder = "Search">
            </div>
        </div>
        <div class="navbar-center">
            <ul class = "navbar-control">
                <li>
                    <a href = "#"  class = "active-link">
                        <img src = "">
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href = "#">
                        <img src = "">
                        <span>My Network</span>
                    </a>
                </li>
                <li>
                    <a href = "#">
                        <img src = "">
                        <span>Jobs</span>
                    </a>
                </li>
                <li>
                    <a href = "#">
                        <img src = "">
                        <span>Messaging</span>
                    </a>
                </li>
                <li>
                    <a href = "#">
                        <img src = "">
                        <span>Notifications</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="navbar-right">

        </div>
    </nav>

    <div class="container">
        <div class="left-sidebar">
            <div class="filter-sort">
                <div class="filter">
                    <h3>Filter</h3>
                    <div class="filter-location">
                        <p><strong>Lokasi</strong></p>
                        <form>
                            <label><input type="checkbox" name="fl-colour" value="on-site" /> On-site</label>
                            <label><input type="checkbox" name="fl-colour" value="remote" /> Remote</label> 
                            <label><input type="checkbox" name="fl-colour" value="hybrid" /> Hybrid</label>
                        </form>
                    </div>
                    <div class="filter-jenis">
                        <p><strong>Jenis pekerjaan</strong></p>
                        <form>
                            <label><input type="checkbox" name="job-type" value="full-time" /> Full time</label>
                            <label><input type="checkbox" name="job-type" value="part-time" /> Part time</label> 
                            <label><input type="checkbox" name="job-type" value="internship" /> Internship</label>
                        </form>
                    </div>
                </div>
                <div class="sort">
                    <p><strong>Waktu rilis</strong></p>
                    <form>
                        <label><input type="radio" id="terbaru" name="job_sort" value="terbaru"> Terbaru</label>
                        <label><input type="radio" id="terlama" name="job_sort" value="terlama"> Terlama</label>
                    </form>
                </div>
            </div>
            <div class="logout">
                <button type="button">Search</button>
            </div>
        </div>
        <div class="main-content">
            <button class="add-job">
                <i class="fa-solid fa-plus"></i>
                Add job
            </button>
            
            <div class="show-jobs">
                <div class="job">
                    <div class="job-author">
                        <div class="author">
                            <h1>Google</h1>
                            <small>2 hours ago</small>
                        </div>
                        <div class="delete-job">
                            <i class="far fa-edit"></i>
                            <i class="fa-solid fa-trash"></i>
                        </div>
                    </div>
                    <div class="job-info">
                        <div>
                            <p><strong>Job Types: </strong>Full Time</p>
                            <p><strong>Position: </strong>Software Engineer</p>
                            <div class="job-location">
                                <i class="fa-solid fa-location-dot"></i>
                                <p>Remote</p>
                            </div>
                        </div>
                    </div>
                    <div class="job-details">
                        <a href="#">More details</a>
                    </div>
                </div>
                <div class="job">
                    <div class="job-author">
                        <div class="author">
                            <h1>Microsoft</h1>
                            <small>3 hours ago</small>
                        </div>
                        <div class="delete-job">
                            <i class="far fa-edit"></i>
                            <i class="fa-solid fa-trash"></i>
                        </div>
                    </div>
                    <div class="job-info">
                        <div>
                            <p><strong>Job Types: </strong>Technology</p>
                            <p><strong>Position: </strong>Frontend Developer</p>
                            <div class="job-location">
                                <i class="fa-solid fa-location-dot"></i>
                                <p>Remote</p>
                            </div>
                        </div>
                    </div>
                    <p>
                        Microsoft is looking for a Frontend Developer to join our team and help build innovative applications.
                    </p>
                    <div class="job-details">
                        <a href="#">More details</a>
                    </div>
                </div>

                <div class="job">
                    <div class="job-author">
                        <div class="author">
                            <h1>Facebook</h1>
                            <small>4 hours ago</small>
                        </div>
                        <div class="delete-job">
                            <i class="far fa-edit"></i>
                            <i class="fa-solid fa-trash"></i>
                        </div>
                    </div>
                    <div class="job-info">
                        <div>
                            <p><strong>Job Types: </strong>Social Media</p>
                            <p><strong>Position: </strong>Data Scientist</p>
                            <div class="job-location">
                                <i class="fa-solid fa-location-dot"></i>
                                <p>New York, NY</p>
                            </div>
                        </div>
                    </div>
                    <p>
                        We are seeking a Data Scientist to derive insights from user data and inform our product strategies at Facebook.
                    </p>
                    <div class="job-details">
                        <a href="#">More details</a>
                    </div>
                </div>

                <div class="job">
                    <div class="job-author">
                        <div class="author">
                            <h1>Amazon</h1>
                            <small>5 hours ago</small>
                        </div>
                        <div class="delete-job">
                            <i class="far fa-edit"></i>
                            <i class="fa-solid fa-trash"></i>
                        </div>
                    </div>
                    <div class="job-info">
                        <div>
                            <p><strong>Job Types: </strong>Retail</p>
                            <p><strong>Position: </strong>Operations Manager</p>
                            <div class="job-location">
                                <i class="fa-solid fa-location-dot"></i>
                                <p>Seattle, WA</p>
                            </div>
                        </div>
                    </div>
                    <p>
                        Amazon is looking for an Operations Manager to oversee our logistics and supply chain management.
                    </p>
                    <div class="job-details">
                        <a href="#">More details</a>
                    </div>
                </div>

                <div class="job">
                    <div class="job-author">
                        <div class="author">
                            <h1>Apple</h1>
                            <small>6 hours ago</small>
                        </div>
                        <div class="delete-job">
                            <i class="far fa-edit"></i>
                            <i class="fa-solid fa-trash"></i>
                        </div>
                    </div>
                    <div class="job-info">
                        <div>
                            <p><strong>Job Types: </strong>Technology</p>
                            <p><strong>Position: </strong>iOS Developer</p>
                            <div class="job-location">
                                <i class="fa-solid fa-location-dot"></i>
                                <p>Remote</p>
                            </div>
                        </div>
                    </div>
                    <p>
                        Apple seeks an iOS Developer to create seamless applications and improve existing functionalities in our mobile services.
                    </p>
                    <div class="job-details">
                        <a href="#">More details</a>
                    </div>
                </div>

                <div class="pagination">
                    <li class="page-item previous-page disable">
                        <a href="#" class="page-link">Prev</a>
                    </li>
                    <li class="page-item current-page active">
                        <a href="#" class="page-link">1</a>
                    </li>
                    <li class="page-item dots">
                        <a href="#" class="page-link">...</a>
                    </li>
                    <li class="page-item current-page">
                        <a href="#" class="page-link">5</a>
                    </li>
                    <li class="page-item current-page">
                        <a href="#" class="page-link">6</a>
                    </li>
                    <li class="page-item dots">
                        <a href="#" class="page-link">...</a>
                    </li>
                    <li class="page-item current-page">
                        <a href="#" class="page-link">10</a>
                    </li>
                    <li class="page-item next-page">
                        <a href="#" class="page-link">Next</a>
                    </li>
                </div>
            </div>
            
        </div>
    </div>

    <script src="home.js"></script>
</body>
</html>