<?php
namespace Controller;

use Model\UserModel;

class UserController extends Controller{
    private $userModel;
    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function register() {
        $role = $_POST["role"];
        $data = [];

        if ($role === "jobseeker") {
            $data = [
                "role" => $role,
                "nama" => $_POST["name"],
                "email" => $_POST["email"],
                "password" => $_POST["password"]
            ];
        } else {
            $data = [
                "role" => $role,
                "nama" => $_POST["name_company"],
                "email" => $_POST["email_company"],
                "lokasi" => $_POST["location"],
                "about" => $_POST["about"],
                "password" => $_POST["password"]
            ];
        }

        $userId = $this->userModel->addUser($data);

        header("Location: /login");
        exit();
    }

    public function editUser($id, $data) {
        if (isset($data['email'])) {
            $this->userModel->editEmail($id, $data['email']);
        }

        if (isset($data['nama'])) {
            $this->userModel->editName($id, $data['nama']);
        }

        if (isset($data['password'])) {
            $this->userModel->editPassword($id, $data['password']);
        }

        if (isset($data['lokasi'])) {
            $this->userModel->editLocation($id, $data['lokasi']);
        }

        if (isset($data['about'])) {
            $this->userModel->editAbout($id, $data['about']);
        }

        return [
            "success" => true
        ];
    }

    public function deleteUser($id) {
        if ($this->userModel->deleteUser($id)) {
            return [
                "success" => true, 
                "message" => "User deleted successfully."
            ];
        }
        return [
            "success" => false, 
            "message" => "User could not be deleted."
        ];
    }

    public function getAllUsers() {
        $users = $this->userModel->getAllUsers();
        return [
            "success" => true, 
            "data" => $users
        ];
    }

    public function showRegister(){
        $this->view("/general/register");
    }

    public function showLogin(){
        // $allLowongan = $this->lowonganModell->getAllLowongan();
        // $this->view("/general/login", allLowoongan);
        $this->view("/general/login");
    }

    public function showHome() {
        if(isset($_SESSION["role"])) {
            $role = $_SESSION["role"];

            if($role === "jobseeker") {
                $this->view("/jobseeker/home");
            } else if($role === "company") {
                $this->view("/company/home");
            } else {
                header("Location: /login");
                exit();
            }
        } else {
            header("Location: /login");
            exit();
        }
        // $this->view("/jobseeker/home");
    }
}