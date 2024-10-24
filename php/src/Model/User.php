<?php

namespace Model;
use Core\DbCon;

class User {
    private $db;

    public function __construct() {
        $this->db = DbCon::getInstance();
    }

    public function userExists($email): bool {
        $result = $this->db->prepareQuery("SELECT COUNT(*) FROM users WHERE email = :email", ["email" => $email]);
        return $result[0]["count"] > 0;
    }

    public function verifyUser($email, $password): bool {
        $result = $this->db->prepareQuery("SELECT * FROM users WHERE email = :email", ["email" => $email]);

        // if(count($result) > 0) {
        //     $user = $result[0];
        //     return password_verify($password, $user["password"]);
        // } else {
        //     return false;
        // }

        return true;
    }

    public function addUser($data): int {
        $data["newpassword"] = password_hash($data["password"], PASSWORD_DEFAULT);
        
        $userData = [
            "nama" => $data["nama"],
            "email" => $data["email"],
            "password" => $data["newpassword"],
            "role" => $data["role"]
        ];

        $userId = $this->db->insert("users", $userData);
        
        if ($data["role"] === "company") {
            $companyDetails = [
                "user_id" => $userId,
                "lokasi" => $data["lokasi"],
                "about" => $data["about"]
            ];
            $this->db->insert("companydetail", $companyDetails);
        }

        return $userId;
    }

    public function getAllUsers() {
        return $this->db->rawQuery("SELECT * FROM users");
    }

    public function getUserById($userId,$attr="*") {
        return $this->db->findById("users",  $userId,$attr);
    }

    public function getUsersByRole($role) {
        return $this->db->prepareQuery("SELECT * FROM users WHERE role = :role", ["role" => $role]);
    }

    public function getUserByEmail($email) {
        $result = $this->db->prepareQuery("SELECT * FROM users WHERE email = :email", ["email" => $email]);
        return count($result) > 0 ? $result : null;
    }

    public function getUserRole($id) {
        return $this->db->prepareQuery("SELECT * FROM users WHERE email = :id", ["id" => $id]);
    }

    public function getCompanyDetails($id){
        $company_details = $this->db->fetchQuery("SELECT lokasi,about FROM companydetail WHERE user_id=:id",["id"=>$id]);
        if(!$company_details){
            return [];
        }
        $company_details['company_name'] = $this->db->findById("users",$id,"nama");
        return $company_details;
    }

    public function editEmail($id, $newEmail): bool {
        return $this->db->update("users", ["email" => $newEmail], "id = :id", ["id" => $id]) > 0;
    }

    public function editName($id, $newName): bool {
        return $this->db->update("users", ["nama" => $newName], "id = :id", ["id" => $id]) > 0;
    }
    
    public function editPassword($id, $newPassword): bool {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        return $this->db->update("users", ["password" => $hashedPassword], "id = :id", ["id" => $id]) > 0;
    }

    public function editLocation($id, $newLocation): bool {
        return $this->db->update("companydetail", ["lokasi" => $newLocation], "user_id = :id", ["id" => $id]) > 0;
    }

    public function editAbout($id, $newAbout): bool {
        return $this->db->update("companydetail", ["about" => $newAbout], "user_id = :id", ["id" => $id]) > 0;
    }

    public function deleteUser($id): bool {
        return $this->db->delete("users", "id = :id", ["id" => $id]) > 0;
    }
}