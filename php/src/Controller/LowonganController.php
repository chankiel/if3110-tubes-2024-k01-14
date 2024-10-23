<?php

namespace Controller;

use Model\Lowongan;
use Model\User;
use Helper\Validator;
use Helper\FileManager;

class LowonganController extends Controller
{
    private Lowongan $lowongan;

    public function __construct()
    {
        parent::__construct();
        $this->lowongan  = new Lowongan();
    }

    public function showTambahLowongan()
    {
        $this->view("/company/TambahLowongan");
    }

    public function showDetailJS($matches)
    {

        $lowongan_id = $matches[0];
        $data = $this->lowongan->getDetailLowongan($lowongan_id, $this->cur_user['id']??-1);
        if (!$data) {
            header("Location: /not-found");
            exit();
        }
        $this->view("/jobseeker/DetailLowongan", $data);
    }

    public function validateLowongan($lowongan_id, $user_id, $isCud)
    {
        $lowongan = $this->lowongan->getLowonganById($lowongan_id);
        if (!$lowongan) {
            header("Location: /not-found");
            exit();
        }

        if ($isCud && $lowongan['company_id'] !== (int)$user_id) {
            header("Location: /not-found");
            exit();
        }

        return $lowongan;
    }

    public function showEditLowongan($matches)
    {
        $this->authorizeRole("company");
        $lowongan_id = $matches[0];

        $lowongan = $this->validateLowongan($lowongan_id, $this->cur_user['id'], true);
        $this->view("/company/editLowongan", $lowongan);
    }

    public function showDetailLowonganCompany($matches) {
        $this->authorizeRole("company");
        $lowongan_id = $matches[0];
        $data = $this->lowongan->getDataPelamar($lowongan_id);
        if (!$data) {
            header("Location: /not-found");
            exit();
        }
        $this->view("/company/DetailLowongan", $data);
    }

    public function validateDetailsLowongan($validator, &$hasFiles, $isAdd)
    {
        $lowonganData = [
            "posisi" => $_POST['posisi'] ?? null,
            "deskripsi" => $_POST['deskripsi'] ?? null,
            "jenis_pekerjaan" => $_POST['jenis_pekerjaan'] ?? null,
            "jenis_lokasi" => $_POST['jenis_lokasi'] ?? null,
        ];

        $validator->required("posisi", $lowonganData['posisi'], 'Position')
            ->required("deskripsi", $lowonganData['deskripsi'], 'Job\'s description');
        if ($isAdd) {
            $validator->required("jenis_pekerjaan", $lowonganData['jenis_pekerjaan'], 'Job\'s type')
                ->required("jenis_lokasi", $lowonganData['jenis_lokasi'], 'Location\'s type');
        }

        $validator->string("posisi", $lowonganData['posisi'], 'Position')
            ->string("deskripsi", $lowonganData['deskripsi'], 'Job\'s description');
        if (!empty($lowonganData['jenis_pekerjaan'])) {
            $validator->enum("jenis_pekerjaan", $lowonganData['jenis_pekerjaan'], ['Full-time', 'Part-time', 'Internship'], 'Job\'s type');
        }
        if (!empty($lowonganData['jenis_lokasi'])) {
            $validator->enum("jenis_lokasi", $lowonganData['jenis_lokasi'], ['Remote', 'On-site', 'Hybrid'], 'Location\'s type');
        }

        $allowedMimeTypes = ['image/jpeg', 'image/png'];
        $allowedExtensions = ['jpeg', 'png', 'jpg'];
        foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
            $fileName = $_FILES['files']['name'][$key];
            $fileTmpName = $_FILES['files']['tmp_name'][$key];

            if ($_FILES['files']['error'][$key] === UPLOAD_ERR_NO_FILE || empty($fileTmpName)) {
                continue;
            }
            $hasFiles = true;

            $validator->fileExtension('files', $fileName, $allowedExtensions, "File $fileName");
            $validator->fileType('files', $fileTmpName, $allowedMimeTypes, "File $fileName");
        }
        $lowonganData = array_filter($lowonganData, function ($value) {
            return !is_null($value);
        });
        return $lowonganData;
    }

    public function uploadAttachments($lowongan_id)
    {
        foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
            $fileTmpName = $_FILES['files']['tmp_name'][$key];
            $fileName = $_FILES['files']['name'][$key];

            if ($_FILES['files']['error'][$key] === UPLOAD_ERR_NO_FILE || empty($fileTmpName)) {
                continue;
            }
            $fileUrl = FileManager::uploadFile('/public/', 'attachments', $fileTmpName, $fileName);

            if ($fileUrl) {
                $this->lowongan->addAttachment($fileUrl, $lowongan_id);
            }
        }
    }

    public function tambahLowongan()
    {
        $this->authorizeRole("company");

        $validator = new Validator();
        $hasFiles = false;
        $lowonganData = $this->validateDetailsLowongan($validator, $hasFiles, true);

        if (!$validator->passes()) {
            $this->handleErrors($validator->errors());
            header("Location: /jobs/add");
            exit();
        }

        $lowonganData['company_id'] = $this->cur_user['id'];
        $lowonganData['company_name'] = $this->cur_user['email'];

        $lowongan_id = $this->lowongan->addLowongan($lowonganData);

        if ($hasFiles) {
            $this->uploadAttachments($lowongan_id);
        }

        session_start();
        $response =  [
            "success" => true,
            "message" => "Job updated successfully!"
        ];

        $_SESSION['response'] = $response;
        header("Location: /jobs/$lowongan_id");
        exit();
    }

    public function editLowongan($matches)
    {
        $this->authorizeRole("company");

        $lowongan_id = $matches[0];
        $validator = new Validator();

        $lowongan = $this->validateLowongan($lowongan_id, $this->cur_user['id'], true);
        $hasFiles = false;
        $lowonganData = $this->validateDetailsLowongan($validator, $hasFiles, false);

        if (!$validator->passes()) {
            $this->handleErrors($validator->errors());
            header("Location: /jobs/edit/{$lowongan_id}");
            exit();
        }

        $this->lowongan->updateLowongan($lowonganData, "id=:id", ['id' => $lowongan_id]);

        if ($hasFiles) {
            $this->lowongan->deleteAttachments($lowongan_id);
            $this->uploadAttachments($lowongan_id);
        }

        session_start();
        $response =  [
            "success" => true,
            "message" => "Job updated successfully!"
        ];

        $_SESSION['response'] = $response;
        header("Location: /jobs/edit/{$lowongan_id}");
        exit();
    }

    public function deleteLowongan($matches)
    {
        $this->authorizeRole("company");
    
        $lowongan_id = $matches[0];
        $lowongan = $this->validateLowongan($lowongan_id,$this->cur_user['id'],true);

        $this->lowongan->deleteLowongan("id= :id", ["id" => $lowongan_id]);
        $this->lowongan->deleteAttachments($lowongan_id);
        
        session_start();
        $response =  [
            "success" => true,
            "message" => "Job deleted successfully!"
        ];

        $_SESSION['response'] = $response;
        header("Location: /");
        exit();
    }  

    public function getOpenLowongan()
    {
        $user_id = $_COOKIE['user_id'] ?? null;
        $role = $_COOKIE['user_role'] ?? null;
        
        $search = $_GET['search'] ?? '';
        $location = isset($_GET['filter']) ? implode(',', $_GET['filter']) : '';
        $job_type = isset($_GET['job-type']) ? implode(',', $_GET['job-type']) : '';
        $sort = $_GET['sort'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 3;
    
        $allLowongan = $this->fetchOpenLowongan($search, $location, $job_type, $sort);

        $totalJobs = count($allLowongan);

        $totalPages = ceil($totalJobs / $perPage);

        $jobs = array_slice($allLowongan, ($page - 1) * $perPage, $perPage);

        $jobListHtml= $this->renderJobAndPagination($jobs, $page, $totalPages);

        echo $jobListHtml;
        exit;
        // return $jobListHtml;
    }


    public function changeOpenClosed($matches){
        $is_open = $_POST["action"];
        $lowongan_id = $matches[0];
        if ($is_open === "close") {
            $status = false;
        } else {
            $status = true;
        }
        $this->lowongan->updateLowongan(['is_open'=>$status], "id=:id", ['id' => $lowongan_id]);
        session_start();
        
        $response =  [
            "success" => true,
            "message" => "status change succesfully!"
        ];
        $_SESSION['response'] = $response;
        header("Location: /jobs/$lowongan_id");
    }

    public function fetchOpenLowongan($search, $location, $job_type, $sort) 
    {
        return $this->lowongan->getAllOpenLowongan($search, $location, $job_type, $sort);
    }  

    public function renderJobAndPagination($jobs, $currentPage, $totalPages) 
    {
        $html = '<div class="job-list">';
        
        if (empty($jobs)) {
            return $html .= '<div class="no-jobs"><h2>No job listings available</h2></div></div>';
        } else {
            if(isset($_COOKIE["role"]) && $_COOKIE["role"] === "company") {
                foreach ($jobs as $job) {
                    $html .= "<div class='job'>
                                <div class='job-author'>
                                    <div class='author'>
                                        <h1>" . htmlspecialchars($job['posisi']) . "</h1>
                                        <p>" . htmlspecialchars($job['jenis_pekerjaan']) . "</p>
                                    </div>
                                    <div class='delete-job'>
                                        <a href='/jobs/". htmlspecialchars($job['lowonganid']) ."' title='Edit Job'>
                                            <i class='far fa-edit'></i>
                                        </a>
                                        <a href='/jobs/". htmlspecialchars($job['lowonganid']) ."/delete' title='Delete Job'>
                                            <i class='fa-solid fa-trash'></i>
                                        </a>
                                    </div>
                                </div>
                                <div class='job-info'>
                                    <div class='job-type-location'>
                                        <h2>
                                            <strong>
                                                <a title='View Author Profile' class='company-name'>" . htmlspecialchars($job['nama']) . "</a>
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
                                    <a href='/jobs/". htmlspecialchars($job['lowonganid']) ."/details'>More details</a>
                                </div>
                            </div>";
                }
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
                                                <a title='View Author Profile' class='company-name'>" . htmlspecialchars($job['nama']) . "</a>
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
                                    <a href='/jobs/". htmlspecialchars($job['lowonganid']) ."/details'>More details</a>
                                </div>
                            </div>";
                }
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
    
            if ($currentPage < $totalPages) {
                $html .= '<li class="page-item next-page"><a class="page-link" onclick="fetchJobs(' . ($currentPage + 1) . ')">Next »</a></li>';
            } else {
                $html .= '<li class="page-item next-page disabled"><a class="page-link" href="javascript:void(0)">Next »</a></li>';
            }
        
            $html .= '</ul></div>';
        }
        return $html;
    }
}