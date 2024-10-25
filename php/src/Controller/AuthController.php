<?php

namespace Controller;

use Model\User;

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login()
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        if ($this->userModel->verifyUser($email, $password)) {
            $user = $this->userModel->getUserByEmail($email);

            if ($user) {
                $user = $user[0];
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["email"] = $user["email"];
                $_SESSION["nama"] = $user["nama"];
                $_SESSION["role"] = $user["role"];

                header('Location: /');
                exit();
            }
        } else {
            $_SESSION["error_message"] = "Invalid email or password";
            header('Location: /login');
            exit();
        }
    }

    public function logout()
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION["user_id"]);
        unset($_SESSION["nama"]);
        unset($_SESSION["email"]);
        unset($_SESSION["role"]);
        header('Location: /');
        exit();
    }

    public static function getCurrentUser()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user_id'])) {
            return [
                "success" => true,
                "user" => [
                    "id" => $_SESSION['user_id'],
                    "email" => $_SESSION['email'],
                    "role" => $_SESSION['role'],
                    "nama" => $_SESSION['nama'],
                ]
            ];
        }

        return [
            "success" => false,
            "message" => "No user is logged in"
        ];
    }

    public function isLoggedIn()
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']);
    }

    public function getRole()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['role'];
    }

    public function getEmail()
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['email'];
    }

    public function getNama()
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['nama'];
    }

    public function getUserId()
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['user_id'];
    }
}
