<?php

namespace Controller;

use Model\UserModel;

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login() {
        $email = $_POST["email"];
        $password = $_POST["password"];

        if ($this->userModel->verifyUser($email, $password)) {
            $user = $this->userModel->getUserByEmail($email);
    
            if ($user) {
                $user = $user[0];
    
                setCookie("user_id", $user["id"], time() + 86400, "/");
                setCookie("email", $user["email"], time() + 86400, "/");
                setCookie("role", $user["role"], time() + 86400, "/");
    
                header('Location: /');
                exit();
            }
        } else {
            $_COOKIE["error_message"] = "Invalid email or password";
            header('Location: /login');
            exit();
        }
    }
    
    public function logout() {
        setcookie("user_id", "", time() - 86400, "/");
        setcookie("email", "", time() - 86400, "/");
        setcookie("role", "", time() - 86400, "/");

        return [
            "success" => true,
            "message" => "Logged out successfully"
        ];
    }

    public static function getCurrentUser() {
        if (isset($_COOKIE['user_id'])) {
            return [
                "success" => true,
                "user" => [
                    "id" => $_COOKIE['user_id'],
                    "email" => $_COOKIE['email'],
                    "role" => $_COOKIE['role']
                ]
            ];
        }

        return [
            "success" => false,
            "message" => "No user is logged in"
        ];
    }

    public function isLoggedIn() {
        return isset($_COOKIE['user_id']);
    }
}