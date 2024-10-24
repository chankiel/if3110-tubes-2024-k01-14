<?php

namespace Controller;

use Helper\Validator;
use Model\User;

class UserController extends Controller
{
    private $user;
    private $userAuth;
    private $lowonganCon;
    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
        $this->userAuth = new AuthController();
        $this->lowonganCon = new LowonganController();
    }

    public function register()
    {
        $role = $_POST["role"];
        $data = [];

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if ($this->user->userExists($_POST["email"]) || $this->user->userExists($_POST["email_company"])) {
            $_SESSION["error_message"] = "Email is already registered.";
            header('Location: /register');
            exit();
        }

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
                "password" => $_POST["password_company"]
            ];
        }

        $this->user->addUser($data);

        header("Location: /login");
        exit();
    }

    public function editCompany()
    {
        parse_str(file_get_contents("php://input"), $data);
        $userData = [
            'nama' => $data['nama'] ?? null,
            'lokasi' => $data['lokasi'] ?? null,
            'about' => $data['about'] ?? null,
        ];

        $validator = new Validator();
        $validator->required("nama", $userData['nama'], 'Company\'s name')
            ->required("lokasi", $userData['lokasi'], 'Company\'s location ')
            ->required("about", $userData['about'], 'Company\'s about ');

        $validator->string("nama", $userData['nama'], 'Company\'s name')
            ->string("lokasi", $userData['lokasi'], 'Company\'s location ')
            ->string("about", $userData['about'], 'Company\'s about ');

        if (!$validator->passes()) {
            return $this->handleErrors($validator->errors());
        }

        $this->user->editName($this->cur_user['id'], $userData['nama']);
        $this->user->editLocation($this->cur_user['id'], $userData['lokasi']);
        $this->user->editAbout($this->cur_user['id'], $userData['about']);


        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $response =  [
            "success" => true,
            "message" => "Company's Profile updated successfully!"
        ];
        $_SESSION['response'] = $response;
        return $response;
    }

    public function deleteUser($id)
    {
        if ($this->user->deleteUser($id)) {
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

    public function getAllUsers()
    {
        $users = $this->user->getAllUsers();
        return [
            "success" => true,
            "data" => $users
        ];
    }

    public function showRegister()
    {
        $this->view("/general/register");
    }

    public function showLogin()
    {
        $this->view("/general/login");
    }

    public function showHome()
    {
        $search = $_GET['search'] ?? '';
        $location = $_GET['filter'] ?? [];
        $job_type = $_GET['job-type'] ?? [];
        $sort = $_GET['sort'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 3;

        $jobListHtml = '';

        $allLowongan = $this->lowonganCon->fetchOpenLowongan($search, $location, $job_type, $sort, $page, $perPage);

        $totalJobs = count($allLowongan);
        $totalPages = ceil($totalJobs / $perPage);
        $jobs = array_slice($allLowongan, ($page - 1) * $perPage, $perPage);

        $jobListHtml = $this->lowonganCon->renderJobAndPagination($jobs, $page, $totalPages);

        $data = [
            "jobListHtml" => $jobListHtml,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ];

        $this->view("general/home", $data);
    }

    public function showLogout()
    {
        $this->userAuth->logout();
    }

    public function showProfileCompany()
    {
        $this->authorizeRole("company");
        $company_details = $this->user->getCompanyDetails($this->cur_user['id']);
        $this->view("/company/ProfileCompany", $company_details);
    }
}
