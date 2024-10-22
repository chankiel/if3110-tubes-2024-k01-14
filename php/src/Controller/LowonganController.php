<?php
namespace Controller;
use Model\Lowongan;
use Model\User;
use Helper\Validator;
use Helper\FileManager;

class LowonganController extends Controller {
    private Lowongan $lowongan;
    private User $user;

    public function __construct(){
        parent::__construct();
        $this->lowongan  = new Lowongan();
        $this->user = new User();
    }    

    public function showTambahLowongan(){
        $this->view("/company/FormTambahLowongan",[]);
    }

    public function showDetailJS($matches){
        $lowongan_id = $matches[0];
        $data = $this->lowongan->getDetailLowongan($lowongan_id,$this->cur_user['id']);
        if(!$data){
            header("Location: /not-found");
            exit();
        }
        $this->view("/jobseeker/DetailLowongan",$data);
    }

    public function showEditLowongan($matches){
        $lowongan_id = $matches[0];

        // Cek lowongan id valid
        $lowongan = $this->lowongan->getLowonganById($lowongan_id);
        if (!$lowongan) {
            header("Location: /not-found");
        }

        $data = [
            "lowongan_id" => $lowongan_id,
        ];

        $this->view("/company/editLowongan", $data);
    }

    public function tambahLowongan(){
        $validator = new Validator();
        $target_url = "/";

        $company_id =  $_COOKIE["user_id"];

        $posisi = $_POST["posisi"];
        $validator->string("posisi",$posisi,"Posisi");
        if(!$validator->passes()){
            return $validator->errors();
        }

        $deskripsi = $_POST["deskripsi"];
        $validator->string("deskripsi",$deskripsi,"Deskripsi");
        if(!$validator->passes()){
            return $validator->errors();
        }

        $jenis_pekerjaan =$_POST["jenis_pekerjaan"];
        $jenis_lokasi = $_POST["jenis_lokasi"];
        // // validasi belum
        // $image_path = FileManager::uploadFile("cv");

        $dataLowongan = [
            "company_id" => $company_id,
            "posisi" => $posisi,
            "deskripsi" => $deskripsi,
            "jenis_pekerjaan" =>$jenis_pekerjaan ,
            "jenis_lokasi"=> $jenis_lokasi,
            // "file_path"=> $image_path??"",
        ];
        
                
        $this->lowongan->addLowongan($dataLowongan);
        
        header("Location: $target_url");
    }

    public function editLowongan($lowongan_id){
        $validator = new Validator();
        $target_url = "/";
        
        $company_id =  $_COOKIE["user_id"];

        $posisi = $_POST["posisi"];
        $validator->string("posisi",$posisi,"Posisi");
        if(!$validator->passes()){
            return $validator->errors();
        }

        $deskripsi = $_POST["deskripsi"];
        $validator->string("deskripsi",$deskripsi,"Deskripsi");
        if(!$validator->passes()){
            return $validator->errors();
        }

        $jenis_pekerjaan =$_POST["jenis_pekerjaan"];
        $jenis_lokasi = $_POST["jenis_lokasi"];

        // // validasi belum
        // $image_path = FileManager::uploadFile("cv");

        $dataLowongan = [
            "company_id" => $company_id,
            "posisi" => $posisi,
            "deskripsi" => $deskripsi,
            "jenis_pekerjaan" =>$jenis_pekerjaan ,
            "jenis_lokasi"=> $jenis_lokasi,
            "file_path"=> $image_path??""
        ];

        $condition = "id= :id";
        $params = ["id" => $lowongan_id];

        $this->lowongan->updateLowongan($dataLowongan, $condition, $params);

        
        header("Location: $target_url");
    }

    public function deleteLowongan($lowongan_id){
        $condition = "id= :id";
        $params = ["id" => $lowongan_id];
        $this->lowongan->deleteLowongan( $condition, $params);
    }

    public function fetchOpenLowongan($user_id, $role, $search, $location, $job_type, $sort, $page, $perPage) {
        if ($role === "company") {
            return $this->lowongan->getAllLowonganByCompany($user_id, $search, $location, $job_type, $sort, $page, $perPage);
        } else {
            return $this->lowongan->getAllOpenLowongan($search, $location, $job_type, $sort, $page, $perPage);
        }
    }    

    public function getOpenLowongan() {
        $user_id = $_COOKIE['user_id'] ?? null;
        $role = $_COOKIE['user_role'] ?? null;
        
        $search = $_GET['search'] ?? '';
        $location = isset($_GET['filter']) ? implode(',', $_GET['filter']) : '';
        $job_type = isset($_GET['job-type']) ? implode(',', $_GET['job-type']) : '';
        $sort = $_GET['sort'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 3;
    
        $allLowongan = $this->fetchOpenLowongan($user_id, $role, $search, $location, $job_type, $sort, $page, $perPage);

        $totalJobs = count($allLowongan);

        $totalPages = ceil($totalJobs / $perPage);

        $jobs = array_slice($allLowongan, ($page - 1) * $perPage, $perPage);

        $jobListHtml= $this->renderJobAndPagination($jobs, $page, $totalPages);

        echo $jobListHtml;
        exit;
        // return $jobListHtml;
    }

    public function renderJobAndPagination($jobs, $currentPage, $totalPages): string {
        $html = '<div class="job-list">';
        
        if (empty($jobs)) {
            return $html .= '<div class="no-jobs"><h2>No job listings available</h2></div></div>';
        } else {
            foreach ($jobs as $job) {
                $html .= "<div class='job'>
                            <div class='job-author'>
                                <div class='author'>
                                    <h1>" . htmlspecialchars($job['posisi']) . "</h1>
                                    <p>" . htmlspecialchars($job['jenis_pekerjaan']) . "</p>
                                </div>
                            </div>
                            <div class='job-info'>
                                <div class='job-type-location'>
                                    <h2>
                                        <strong>
                                            <a href='#' title='View Author Profile' class='company-name'>" . htmlspecialchars($job['nama']) . "</a>
                                        </strong>
                                    </h2>
                                    <div class='job-location'>
                                        <i class='fa-solid fa-location-dot'></i>
                                        <p>" . htmlspecialchars($job['jenis_lokasi']) . "</p>
                                    </div>
                                    <small>" . htmlspecialchars($job['lowongan_diffTime']) . "</small>
                                </div>
                            </div>
                            <div class='job-details'>
                                <a href='#'>More details</a>
                            </div>
                        </div>";
            }
        }
        $html .= '</div>';
    
        if (!empty($jobs)) {
            $html .= '<div class="pagination"><ul>';
        
            if ($currentPage > 1) {
                $html .= '<li class="page-item previous-page"><a class="page-link" onclick="fetchJobs(' . ($currentPage - 1) . ')">« Prev</a></li>';
            } else {
                $html .= '<li class="page-item previous-page disabled"><a class="page-link" href="javascript:void(0)">« Prev</a></li>';
            }
        
            $range = 2;
            $startPage = max(1, $currentPage - $range);
            $endPage = min($totalPages, $currentPage + $range);
        
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i < $startPage || $i > $endPage) {
                    if ($i == 1 || $i == $totalPages) {
                        $activeClass = ($currentPage === $i) ? 'active current-page' : '';
                        $html .= '<li class="page-item ' . $activeClass . '"><a class="page-link" onclick="fetchJobs(' . $i . ')">' . $i . '</a></li>';
                    } elseif ($i == $startPage - 1 || $i == $endPage + 1) {
                        $html .= '<li class="page-item dots"><a class="page-link">...</a></li>';
                    }
                } else {
                    $activeClass = ($currentPage === $i) ? 'active current-page' : '';
                    $html .= '<li class="page-item ' . $activeClass . '"><a class="page-link" onclick="fetchJobs(' . $i . ')">' . $i . '</a></li>';
                }
            }
        
            // Next Page link
            if ($currentPage < $totalPages) {
                $html .= '<li class="page-item next-page"><a class="page-link" onclick="fetchJobs(' . ($currentPage + 1) . ')">Next »</a></li>';
            } else {
                $html .= '<li class="page-item next-page disabled"><a class="page-link" href="javascript:void(0)">Next »</a></li>';
            }
        
            $html .= '</ul></div>';
        }
    
        return $html;
    }
    
    

    // public function renderJobAndPagination($jobs, $currentPage, $totalPages): string {
    //     $html = '<div class="job-list">';
        
    //     if (empty($jobs)) {
    //         return $html .= '<div class="no-jobs"><h2>No job listings available</h2></div><div>';
    //     } else {
    //         foreach ($jobs as $job) {
    //             $posisi = htmlspecialchars($job['posisi'] ?? 'N/A');
    //             $jenisPekerjaan = htmlspecialchars($job['jenis_pekerjaan'] ?? 'N/A');
    //             $nama = htmlspecialchars($job['nama'] ?? 'Unknown');
    //             $jenisLokasi = htmlspecialchars($job['jenis_lokasi'] ?? 'Unknown Location');
    //             $lowonganDiffTime = htmlspecialchars($job['lowongan_diffTime'] ?? 'Unknown Time');
                
    //             $html .= "<div class='job'>
    //                         <div class='job-author'>
    //                             <div class='author'>
    //                                 <h1>{$posisi}</h1>
    //                                 <p>{$jenisPekerjaan}</p>
    //                             </div>
    //                         </div>
    //                         <div class='job-info'>
    //                             <div class='job-type-location'>
    //                                 <h2>
    //                                     <strong>
    //                                         <a href='#' title='View Author Profile' class='company-name'>{$nama}</a>
    //                                     </strong>
    //                                 </h2>
    //                                 <div class='job-location'>
    //                                     <i class='fa-solid fa-location-dot'></i>
    //                                     <p>{$jenisLokasi}</p>
    //                                 </div>
    //                                 <small>{$lowonganDiffTime}</small>
    //                             </div>
    //                         </div>
    //                         <div class='job-details'>
    //                             <a href='#'>More details</a>
    //                         </div>
    //                     </div>";
    //         }
    //     }
    //     $html .= '</div>';

    //     if(empty($jobs)) {
    //         $html .= '
    //             <div class="pagination">
    //                 <li class="page-item previous-page"><a class="page-link" href="javascript:void(0)">Prev</a></li>
    //                 <li class="page-item current-page active"><a class="page-link" href="#">1</a></li>
    //                 <li class="page-item next-page"><a class="page-link" href="javascript:void(0)">Next</a></li>
    //             </div>';
    //     }
    
    //     $html .= '<div class="pagination">';
        
    //     $html .= '</div>'; // Close pagination div
    //     return $html;
    // }

    // Function to render jobs and pagination
    
    // public function renderJobHtml($job): string {
    //     return "<div class='job'>
    //                 <div class='job-author'>
    //                     <div class='author'>
    //                         <h1>" . htmlspecialchars($job['posisi']) . "</h1>
    //                         <p>" . htmlspecialchars($job['jenis_pekerjaan']) . "</p>
    //                     </div>
    //                 </div>
    //                 <div class='job-info'>
    //                     <div class='job-type-location'>
    //                         <h2>
    //                             <strong>
    //                                 <a href='#' title='View Author Profile' class='company-name'>" . htmlspecialchars($job['nama']) . "</a>
    //                             </strong>
    //                         </h2>
    //                         <div class='job-location'>
    //                             <i class='fa-solid fa-location-dot'></i>
    //                             <p>" . htmlspecialchars($job['jenis_lokasi']) . "</p>
    //                         </div>
    //                         <small>" . htmlspecialchars($job['lowongan_diffTime']) . "</small>
    //                     </div>
    //                 </div>
    //                 <div class='job-details'>
    //                     <a href='#'>More details</a>
    //                 </div>
    //             </div>";
    // }

    // public function renderJobHtml($job): string {
    //     $posisi = htmlspecialchars($job['posisi'] ?? 'N/A');
    //     $jenisPekerjaan = htmlspecialchars($job['jenis_pekerjaan'] ?? 'N/A');
    //     $nama = htmlspecialchars($job['nama'] ?? 'Unknown');
    //     $jenisLokasi = htmlspecialchars($job['jenis_lokasi'] ?? 'Unknown Location');
    //     $lowonganDiffTime = htmlspecialchars($job['lowongan_diffTime'] ?? 'Unknown Time');
    
    //     return "<div class='job'>
    //                 <div class='job-author'>
    //                     <div class='author'>
    //                         <h1>{$posisi}</h1>
    //                         <p>{$jenisPekerjaan}</p>
    //                     </div>
    //                 </div>
    //                 <div class='job-info'>
    //                     <div class='job-type-location'>
    //                         <h2>
    //                             <strong>
    //                                 <a href='#' title='View Author Profile' class='company-name'>{$nama}</a>
    //                             </strong>
    //                         </h2>
    //                         <div class='job-location'>
    //                             <i class='fa-solid fa-location-dot'></i>
    //                             <p>{$jenisLokasi}</p>
    //                         </div>
    //                         <small>{$lowonganDiffTime}</small>
    //                     </div>
    //                 </div>
    //                 <div class='job-details'>
    //                     <a href='#'>More details</a>
    //                 </div>
    //             </div>";
    // }
    
    // public function renderPagination($currentPage, $totalPages): string {
    //     $html = '<div class="pagination">';
        
    //     // Previous Page link
    //     if ($currentPage > 1) {
    //         $html .= '<a href="?page=' . ($currentPage - 1) . '" class="prev">« Prev</a>';
    //     }
    
    //     // Display page numbers
    //     for ($i = 1; $i <= $totalPages; $i++) {
    //         if ($i == $currentPage) {
    //             $html .= '<span class="current">' . $i . '</span>'; // Current page indicator
    //         } else {
    //             $html .= '<a href="?page=' . $i . '">' . $i . '</a>'; // Page link
    //         }
    //     }
    
    //     // Next Page link
    //     if ($currentPage < $totalPages) {
    //         $html .= '<a href="?page=' . ($currentPage + 1) . '" class="next">Next »</a>';
    //     }
    
    //     $html .= '</div>';
    //     return $html;
    // }
}