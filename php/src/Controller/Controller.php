<?php

namespace Controller;

use Model\Lamaran;
use Model\Lowongan;
use Model\User;

class Controller
{
    protected $auth;
    protected $cur_user;

    protected User $user;
    protected Lamaran $lamaran;
    protected Lowongan $lowongan;

    public function __construct()
    {
        $this->auth = AuthController::getCurrentUser();
        if (isset($this->auth['user'])) {
            $this->cur_user = $this->auth['user'];
        }
        $this->lamaran = new Lamaran();
        $this->lowongan = new Lowongan();
        $this->user = new User();
    }

    public function model($model)
    {
        $modelClass = "\\Model\\{$model}";
        return new $modelClass();
    }

    public function view($view, $data = [])
    {
        extract($data);
        
        extract($this->auth);

        if(isset($this->cur_user) && $this->cur_user["role"] === "company") {
            $dataRecenApplicant = ["recentApplicants"=>$this->lamaran->getRecentApplicant($this->cur_user["id"])];
            extract($dataRecenApplicant);
        } else {
            $user_id = isset($this->cur_user) ? $this->cur_user["id"] :-1;
            $recommendation = $this->lowongan->getJobsRecommendation($user_id);
            $recommendations = ['recommendations'=> $recommendation];
            extract($recommendations);
        }


        require_once __DIR__ . '/../views/' . $view . '.php';
    }

    public function showNotFound()
    {
        $this->view("/general/not-found");
    }

    public function handleErrors($errors, $url = '')
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $response =  [
            "success" => false,
            "message" => "There are validation errors.",
            "errors" => $errors
        ];

        $_SESSION['response'] = $response;
        if ($url) {
            header("Location: {$url}");
            exit();
        }
        return $response;
    }

    public function authorizeRole($role)
    {
        if(!isset($this->cur_user['role'])){
            header("Location: /login");
            exit();
        }
        if ($this->cur_user['role'] !== $role) {
            header("Location: /not-found");
            exit();
        }
    }

    public function checkRule($rule)
    {
        if ($rule) {
            header("Location: /not-found");
            exit();
        }
    }

    public function seed(){
        $this->user->deleteAllUser();
        $this->lowongan->deleteAllLowongan();
        $this->lamaran->deleteAllLamaran();

        for($i = 1;$i <= 10;$i++){
            $data = [
                "email" => "email$i@gmail.com",
                "password" => "12345678",
                "role" => "jobseeker",
                "nama" => "jobseeker$i"
            ];
            $this->user->addUser($data);            
        }

        for($i = 11;$i <= 20;$i++){
            $data = [
                "email" => "email$i@gmail.com",
                "password" => "12345678",
                "role" => "company",
                "nama" => "company$i",
                "lokasi" => "Institut Teknologi Bandung, Bandung, Indonesia",
                "about" => "We are the number 1 company in Software Engineer. Come join us!",

            ];
            $this->user->addUser($data);            
        }

        $jenis_lokasi = ["Remote","On-site","Hybrid"];
        $jenis_pekerjaan = ["Full-time","Part-time","Internship"];
        $is_open = [true,false];
        for($i = 11; $i<=20;$i++){
            for($j=1;$j<=1000;$j++){
                $data = [
                    "company_id" => $i,
                    "company_name" => "company$i",
                    "posisi" => "Position-$j Company-$i",
                    "deskripsi" => "Responsible for crafting high-quality, scalable, and maintainable software solutions that meet user needs and business objectives. They work closely with cross-functional teams including product managers, designers, and other developers to create efficient and effective software products.",
                    "jenis_pekerjaan" => $jenis_pekerjaan[array_rand($jenis_pekerjaan)],
                    "jenis_lokasi" => $jenis_lokasi[array_rand($jenis_lokasi)],
                    "is_open" => array_rand($is_open)
                ];
                $this->lowongan->addLowongan($data);
            }
        }

        $status = ["accepted","rejected","waiting"];
        for ($i = 1; $i <= 10; $i++) {
            $usedIds = [];
        
            for ($j = 0; $j < 10; $j++) {
                do {
                    $lowonganId = rand(1, 10000);
                } while (in_array($lowonganId, $usedIds));
        
                $usedIds[] = $lowonganId;
        
                $data = [
                    "user_id" => $i,
                    "lowongan_id" => $lowonganId,
                    "cv_path" => "/storage/cv/cv-$j-$lowonganId",
                    "status" => $status[array_rand($status)],
                ];

                $this->lamaran->addLamaran($data);
            }
        }

        echo "Seeding successful!";
    }
}
