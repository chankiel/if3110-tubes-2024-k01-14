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
        $this->lamaran = new Lamaran();
        $this->lowongan = new Lowongan();
        $this->user = new User();
    }

    public function tambahLamaran($matches)
    {
        $validator = new Validator();
        $lowongan_id = $matches[0];
        $target_url = "/jobs/{$matches[0]}/details";

        // Validate lowongan_id integer
        if(!is_numeric($lowongan_id)){
            $validator->customError("lowongan_id", "Lowongan id is invalid");
        }else{
            $validator->integer("lowongan_id",(int)$lowongan_id,"Lowongan id");
        }

        
        if(!$validator->passes()){
            return $validator->errors();
        }

        // Validate lowongan id exists
        if(!$this->lowongan->existsLowongan($lowongan_id)){
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
        if(!$validator->passes()){
            return $this->handleErrors($validator->errors(),$target_url);
        }

        $cv_path = FileManager::uploadFile("cv");
        $video_path = FileManager::uploadFile("video");

        $data = [
            "user_id" => 1,
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

    public function changeStatusLamaran()
    {
        $id = $_POST["id"];
        $data = [
            "status" => $_POST["status"],
            "reason" => $_POST["status_reason"],
        ];
        $condition = "id = :id";
        $param = ["id" => $id];
        $this->lamaran->updateLamaran($data, $condition, $param);
    }

    public function riwayatLamaran($id)
    {
        $this->lamaran->getRiwayatLamaran($id);
    }

    public function showFormLamaran($matches)
    {
        $lowongan_id = $matches[0];

        // Cek lowongan id valid
        $lowongan = $this->lowongan->getLowonganById($lowongan_id);
        if (!$lowongan) {
            header("Location: /not-found");
        }

        // Cek user_id udah pernah lamar lowongan_id
        $lamaran = $this->lamaran->getLamaran(1, $lowongan_id);
        if ($lamaran) {
            $lamaran["lamaran_diffTime"] = DateHelper::timeDifference($lamaran['created_at']);
            unset($lamaran['created_at']);
            
            $this->view("/jobseeker/AlrApplied",$lamaran);
            return;
        }

        $company_name = $this->user->getUserById($lowongan["company_id"],"nama");

        $data = [
            "company_name" => $company_name['nama'],
            "posisi" => $lowongan["posisi"],
            "user_id" => 1,
            "lowongan_id" => $lowongan_id,
        ];

        $this->view("/jobseeker/FormLamaran", $data);
    }

    public function showRiwayat(){
        $this->view("/jobseeker/RiwayatJobSeeker");
    }

    private function handleErrors($errors,$url){
        session_start();
        $_SESSION['response'] = [
            "success" => false,
            "message" => "There are validation errors.",
            "errors" => $errors
        ];

        header("Location: {$url}");
        exit();
    }

    public function showDetailLamaran($matches): void{
        $lamaran_id = $matches[0];
        // $company_id = $_COOKIE["user_id"];
        $data = $this->lamaran->getDetailLamaran( $lamaran_id);
        if(!$data){
            header("Location: /not-found");
            exit();
        }
        $this->view("/company/DetailLamaran",$data);
    }


}
