<?php

namespace Controller;

use Model\UserModel;

class AuthController {
    private $userModel;

    public function __construct() {
        session_start();
        $this->userModel = new UserModel();
    }

    public function login() {
        $email = $_POST["email"];
        $password = $_POST["password"];
    
        if ($this->userModel->verifyUser($email, $password)) {
            $user = $this->userModel->getUserByEmail($email);
    
            if ($user) {
                $user = $user[0];
    
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["email"] = $user["email"];
                $_SESSION["role"] = $user["role"];
    
                error_log("User Role: " . $_SESSION["role"]);
    
                header("Location: /");
                exit();
            }
        } else {
            error_log("Login failed for email: $email");
            exit();
        }
    }
    

    public function logout() {
        session_destroy();

        return [
            "success" => true,
            "message" => "Logged out successfully"
        ];
    }

    public static function getCurrentUser() {
        if (isset($_SESSION['user_id'])) {
            return [
                "success" => true,
                "user" => [
                    "id" => $_SESSION['user_id'],
                    "email" => $_SESSION['email'],
                    "role" => $_SESSION['role']
                ]
            ];
        }

        return [
            "success" => false,
            "message" => "No user is logged in"
        ];
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}