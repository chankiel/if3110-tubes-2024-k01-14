<?php

namespace Controller;

use Model\Lowongan;
use Model\User;
use Helper\Validator;
use Helper\FileManager;

class LowonganController extends Controller
{
    private Lowongan $lowongan;
    private User $user;

    public function __construct()
    {
        parent::__construct();
        $this->lowongan  = new Lowongan();
        $this->user = new User();
    }

    public function showTambahLowongan()
    {
        $this->view("/company/FormTambahLowongan", []);
    }

    public function showDetailJS($matches)
    {
        $lowongan_id = $matches[0];
        $data = $this->lowongan->getDetailLowongan($lowongan_id, $this->cur_user['id']);
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
        $lowongan_id = $matches[0];

        $lowongan = $this->validateLowongan($lowongan_id, $this->cur_user['id'], true);
        $this->view("/company/editLowongan", $lowongan);
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
    
        $validator = new Validator();

    
        $hasFiles = false;
        $lowonganData = $this->validateDetailsLowongan($validator, $hasFiles, true);

        if (!$validator->passes()) {
            $this->handleErrors($validator->errors());
            header("Location: /");
            exit();
        }

        $lowongan_id =$this->lowongan->addLowongan($lowonganData);

        if ($hasFiles) {
            $this->uploadAttachments($lowongan_id);
        }

        session_start();
        $response =  [
            "success" => true,
            "message" => "Job updated successfully!"
        ];

        $_SESSION['response'] = $response;
        header("Location: /jobs/{$lowongan_id}");
        exit();
    }

    public function editLowongan($matches)
    {
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
        $lowongan_id = $matches[0];
        $lowongan = $this->validateLowongan($lowongan_id,$this->cur_user['id'],true);
        $this->lowongan->deleteLowongan("id= :id", ["id" => $lowongan_id]);
        $this->lowongan->deleteAttachments($lowongan_id);
        
        session_start();
        $response =  [
            "success" => true,
            "message" => "Job updated successfully!"
        ];

        $_SESSION['response'] = $response;
        header("Location: /");
        exit();
    }

    public function getOpenLowongan($user_id, $role)
    {
        if ($role === "company") {
            return $this->lowongan->getAllLowonganByCompany($user_id);
        } else {
            return $this->lowongan->getAllOpenLowongan();
        }
    }
    public function showDetailLowonganCompany($matches){
        $lowongan_id = $matches[0];
        $data = $this->lowongan->getDataPelamar($lowongan_id);
        if(!$data){
            header("Location: /not-found");
            exit();
        }
        // var_dump($data);

        $result = array_merge($data, ["applications" => $data["lamaran_details"]]);
        $this->view("/company/DetailLowongan",$result);
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
}