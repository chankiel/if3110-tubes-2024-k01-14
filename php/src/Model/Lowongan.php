<?php
namespace Model;
use Core\DbCon;

class Lowongan {
    private DbCon $db;
    public function __construct() {
        $this->db = DbCon::getInstance();
    }

    public function addLowongan($data) {
        $this->db->beginTransaction();
        $dataLowongan = array_slice($data,0,5);
        $dataAttachment = array_slice($data,5);
        $lowonganID = $this->db->insert("lowongan", data: $dataLowongan);
        $attachment = array_merge(["id"=> $lowonganID], $dataAttachment);
        $this->db->insert("attachmentlowongan", $attachment);
        $this->db->commit();
    }

    public function updateLowongan($data, $condition, $params){
        return $this->db->update("lowongan", $data, $condition, $params);
    }

    public function deleteLowongan($condition, $params){
        return $this->db->delete("lowongan", $condition, $params);
    }

    public function getLowonganById($id){
        return $this->db->findById('lowongan', $id);
    }

    public function searchFilterSort($posisi, $filter, $sortir){
        $sql = "SELECT * FROM lowongan WHERE posisi is like '%$posisi%' ";
        foreach ($filter as $key => $value) {
            $sql.="AND $key = :$key";
        }

        if ($sortir == "descending") {
            $sql .= "ORDER BY create_at DESC";
        } else {
            $sql .= "ORDER BY create_at ASC";
        }
        $result = $this->db->prepareQuery($sql, $filter);
        return $result;
    }

    // public function searchPosisi($posisi){
    //     $sql = "SELECT * FROM lowongan WHERE posisi is like '%:posisi%' ";
    //     $params = array("posisi"=> $posisi);
    //     $result = $this->db->prepareQuery($sql, $params);
    //     return $result;
    // }

    // public function getAllLowonganByJenisPekerjaan($jenis_pekerjaan){
    //     $sql = "SELECT * FROM lowongan WHERE jenis_pekerjaan = :jenis_pekerjaan ";
    //     $params = array("jenis_pekerjaan" => $jenis_pekerjaan);
    //     $result = $this->db->prepareQuery($sql, $params);
    //     return $result;
    // }

    // public function getAllLowonganByJenisLokasi($jenis_lokasi){
    //     $sql = "SELECT * FROM lowongan WHERE jenis_lokasi = :jenis_lokasi ";
    //     $params = array("jenis_lokasi" => $jenis_lokasi);
    //     $result = $this->db->prepareQuery($sql, $params);
    //     return $result;
    // }

    public function getDetailLowongan($params){
        $sql = "SELECT * FROM lowongan WHERE id = :id ";
        $result = $this->db->prepareQuery($sql, $params);
        return $result;
    }
    
    // public function sortirLowonganByWaktu($isAsc){
    //     $sql = "SELECT * FROM lowongan ORDER BY create_at ";
    //     if ($isAsc) {
    //         $sql .= "ASC";
    //     } else {
    //         $sql .= "DESC";
    //     }
    //     $result = $this->db->query($sql);
    //     return $result;
    // }
}