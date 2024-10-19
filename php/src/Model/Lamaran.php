<?php
namespace Model;
use Core\DbCon;
class Lamaran {
    private DbCon $db;
    public function __construct() {
        $this->db = DbCon::getInstance();
    }

    // CRUD Operation

    public function addLamaran($data){
        return $this->db->insert("lamaran", $data);
    }

    public function updateLamaran($data, $condition, $params){
        return $this->db->update("lamaran", $data, $condition, $params);
    }

    public function deleteLamaran($condition, $params){
        return $this->db->delete("lamaran", $condition, $params);
    }

    public function getLamaranById($id){
        return $this->db->findById('lamaran', $id);
    }

    public function getDaftarLamaranByLowongan($lowongan_id){
        $sql = "SELECT * FROM company WHERE lowongan_id = $lowongan_id";
        return $this->db->query($sql);    
    }

    public function getRiwayatLamaran($id){
        $sql = "SELECT * FROM company WHERE user_id = $id";
        return $this->db->query($sql); 
    } 

}