<?php

class Lowongan {
    private $db;
    public function __construct() {
        $this->db = DbCon::getInstance();
    }

    public function addLowongan($data)
    {
        return $this->db->insert("lowongan", $data);
    }

    public function updateLowongan($data, $condition, $params){
        return $this->db->update("lowongan", $data, $condition, $params);
    }

    public function deleteLowongan($condition, $params){
        return $this->db->delete("lowongan", $condition, $params);
    }

    public function getLamaranById($id){
        return $this->db->findById('lowongan', $id);
    }

    public function searchPosisi($posisi){
        $sql = "SELECT * FROM lowongan WHERE posisi is like ':posisi%' ";
        $params = array("posisi"=> $posisi);
        $result = $this->db->query($sql, $params);
        return $result;
    }
    
    public function getAllLowonganByJenisPekerjaan($jenis_pekerjaan){
        $sql = "SELECT * FROM lowongan WHERE jenis_pekerjaan = :jenis_pekerjaan ";
        $params = array("jenis_pekerjaan" => $jenis_pekerjaan);
        $result = $this->db->prepareQuery($sql, $params);
        return $result;
    }

    public function getAllLowonganByJenisLokasi($jenis_lokasi){
        $sql = "SELECT * FROM lowongan WHERE jenis_lokasi = :jenis_lokasi ";
        $params = array("jenis_lokasi" => $jenis_lokasi);
        $result = $this->db->prepareQuery($sql, $params);
        return $result;
    }
    
    public function sortirLowonganByWaktu($isAsc){
        $sql = "SELECT * FROM lowongan ORDER BY create_at ";
        if ($isAsc) {
            $sql .= "ASC";
        } else {
            $sql .= "DESC";
        }
        $result = $this->db->query($sql);
        return $result;
    }
}