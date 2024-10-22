<?php

namespace Controller;

use Helper\DateHelper;
use Model\Lamaran;
use Model\Lowongan;
use Helper\FileManager;
use Helper\Validator;
use Model\User;

class LamaranController extends Controller
{
    private Lamaran $lamaran;
    private Lowongan $lowongan;
    private User $user;

    public function __construct()
    {
        parent::__construct();
        $this->lamaran = new Lamaran();
        $this->lowongan = new Lowongan();
        $this->user = new User();
    }

    public function tambahLamaran($matches)
    {
        $this->authorizeRole("jobseeker");
        $lowongan_id = $matches[0];
        $validator = new Validator();
        $target_url = "/jobs/{$matches[0]}/details";

        // Validate lowongan id exists
        if (!$this->lowongan->existsLowongan($lowongan_id)) {
            header("Location: /not-found");
            exit();
        }

        // Validate keberadaan CV
        $validator->required('cv', $_FILES['cv']['tmp_name'], 'CV file');

        // Validate tipe CV
        $validator->fileType('cv', $_FILES['cv']['tmp_name'], ['application/pdf'], 'CV file')
            ->fileExtension('cv', $_FILES['cv']['name'], ['pdf'], 'CV file');

        // Validate tipe video kalau ada
        if (!empty($_FILES['video']['tmp_name'])) {
            $validator->fileType('video', $_FILES['video']['tmp_name'], ['video/mp4'], 'Video file')
                ->fileExtension('video', $_FILES['video']['name'], ['mp4'], 'Video file');
        }

        // Cek pass validator
        if (!$validator->passes()) {
            return $this->handleErrors($validator->errors(), $target_url);
        }

        $cv_path = FileManager::getAndUploadFile('/storage/', "cv");
        $video_path = FileManager::getAndUploadFile('/storage/', "video");

        $data = [
            "user_id" => $this->cur_user['id'],
            "lowongan_id" => $lowongan_id,
            "cv_path" => $cv_path,
            "video_path" => $video_path,
            "status" => "waiting",
            "status_reason" => "",
        ];

        $this->lamaran->addLamaran($data);

        session_start();
        $_SESSION['response'] = [
            "success" => true,
            "message" => "Lamaran uploaded successfully!"
        ];

        header("Location: $target_url");
        exit();
    }

    public function changeStatusLamaran($lamaran_id,$status)
    {
        $this->authorizeRole('company');
        $company_id = $this->lamaran->getCompanyId($lamaran_id)['company_id'];
        $this->checkRule($company_id!==(int)$this->cur_user['id']);

        parse_str(file_get_contents("php://input"), $data);
        $status_reason = $data['status_reason'] ?? null;

        $rowCount = $this->lamaran->changeStatusLamaran($status, $status_reason, $lamaran_id);
        session_start();
        if ($rowCount > 0) {
            $_SESSION['response'] = [
                "success" => true,
                "message" => "Lamaran uploaded successfully!"
            ];
        }else{
            $_SESSION['response'] = [
                "success" => false,
                "message" => "Something went wrong!"
            ];
        }
    }

    public function approveLamaran($matches){
        $lamaran_id = $matches[0];
        $this->changeStatusLamaran($lamaran_id,'accepted');
    }

    public function rejectLamaran($matches){
        $lamaran_id = $matches[0];
        $this->changeStatusLamaran($lamaran_id,'rejected');
    }

    public function showFormLamaran($matches)
    {
        $this->authorizeRole("jobseeker");
        $lowongan_id = $matches[0];

        // Cek lowongan id valid
        $lowongan = $this->lowongan->getLowonganById($lowongan_id);
        if (!$lowongan) {
            header("Location: /not-found");
        }

        // Cek user_id udah pernah lamar lowongan_id
        $lamaran = $this->lamaran->getLamaran($this->cur_user['id'], $lowongan_id);
        if ($lamaran) {
            $lamaran["lamaran_diffTime"] = DateHelper::timeDifference($lamaran['created_at']);
            unset($lamaran['created_at']);

            $this->view("/jobseeker/AlrApplied", $lamaran);
            return;
        }

        $company_name = $this->user->getUserById($lowongan["company_id"], "nama");

        $data = [
            "company_name" => $company_name['nama'],
            "posisi" => $lowongan["posisi"],
            "user_id" => $this->cur_user['id'],
            "lowongan_id" => $lowongan_id,
        ];

        $this->view("/jobseeker/FormLamaran", $data);
    }

    public function showRiwayat()
    {
        $this->authorizeRole("jobseeker");
        $lamarans = $this->lamaran->getRiwayatLamaran($this->auth['user']['id']);
        foreach ($lamarans as &$lamaran) {
            $lamaran['lamaran_diffTime'] = DateHelper::timeDifference($lamaran['created_at']);
        }
        $this->view("/jobseeker/RiwayatJobSeeker", ["lamarans" => $lamarans]);
    }

    public function showDetailLamaran($matches): void
    {
        $this->authorizeRole("company");

        $lamaran_id = $matches[0];
        $data = $this->lamaran->getDetailLamaran($lamaran_id);
        $this->checkRule(!$data);

        $this->checkRule($data['company_id'] !== (int)$this->cur_user['id']);

        $this->view("/company/DetailLamaran", $data);
    }
}
