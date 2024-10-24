<?php

namespace Controller;

use Model\Lamaran;
use Model\Lowongan;

class Controller
{
    protected $auth;
    protected $cur_user;

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

        if($this->cur_user["role"] === "company") {
            // for each reactApplicants as 
            $dataRecenApplicant = ["recentApplicants"=>$this->lamaran->getRecentApplicant($this->cur_user["id"])];
        }

        extract($dataRecenApplicant);

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
}
