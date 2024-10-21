<?php

namespace Model;

use Core\DbCon;
use Helper\DateHelper;
class Lowongan
{
    private DbCon $db;
    public function __construct()
    {
        $this->db = DbCon::getInstance();
    }

    public function addLowongan($data)
    {
        $this->db->beginTransaction();
        $dataLowongan = array_slice($data, 0, 5);
        $dataAttachment = array_slice($data, 5);
        $lowonganID = $this->db->insert("lowongan", data: $dataLowongan);
        // $attachment = array_merge(["id" => $lowonganID], $dataAttachment);
        // $this->db->insert("attachmentlowongan", $attachment);
        $this->db->commit();
    }

    public function updateLowongan($data, $condition, $params)
    {
        return $this->db->update("lowongan", $data, $condition, $params);
    }

    public function deleteLowongan($condition, $params)
    {
        return $this->db->delete("lowongan", $condition, $params);
    }

    public function getLowonganById($id)
    {
        return $this->db->findById('lowongan', $id);
    }

    public function existsLowongan($id){
        return ($this->db->fetchQuery("SELECT id FROM lowongan WHERE id=:id",["id"=>$id]));
    }

    public function searchFilterSort($posisi, $filter, $sortir)
    {
        $sql = "SELECT * FROM lowongan WHERE posisi like '%$posisi%' ";
        foreach ($filter as $key => $value) {
            $sql .= "OR $key = :$key";
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

    public function getPreviewOpenLowongan(){
        $allLowongan = $this->db->rawQuery(
            "SELECT nama, posisi, jenis_pekerjaan, jenis_lokasi, created_at FROM lowongan JOIN user ON users.id = lowongan.company_id WHERE lowongan.is_open = TRUE");
        if (!$allLowongan) {
            return[];
        }

        foreach ($allLowongan as $lowongan_diffTime => $value) {
            $lowongan_diffTime["lowongan_diffTime"] = DateHelper::timeDifference($lowongan_diffTime["created_at"]); 
            unset($lowongan_diffTime["created_at"]);
            unset($lowongan_diffTime["updated_at"]);
        }

        return $allLowongan;

        
    }
    public function getDetailLowongan($id)
    {
        // Lowongan Details
        $lowongan_details = $this->db->findById("lowongan", $id);
        if(!$lowongan_details){
            return [];
        }
        $attachments = $this->db->prepareQuery(
            "SELECT file_path FROM attachmentlowongan WHERE lowongan_id= :lowongan_id",
            ["lowongan_id" => $id]
        );

        $lowongan_details["lowongan_diffTime"] = DateHelper::timeDifference($lowongan_details["created_at"]); 

        unset($lowongan_details["created_at"]);
        unset($lowongan_details["updated_at"]);

        // Company Details
        $company = $this->db->fetchQuery("SELECT lokasi,about FROM companydetail WHERE user_id=:company_id",
        ["company_id"=>$lowongan_details['company_id']]);
        $company_name = $this->db->fetchQuery("SELECT nama FROM users WHERE id=:company_id",
        ["company_id"=>$lowongan_details['company_id']]);

        // Data lamaran
        $lamaran_details = $this->db->fetchQuery(
            "SELECT cv_path, video_path, status, status_reason, created_at 
            FROM lamaran 
            WHERE lowongan_id=:lowongan_id AND user_id=:user_id",
            ["lowongan_id" => $id, 'user_id' => 1]
        );

        if($lamaran_details){
            $lamaran_details["lamaran_diffTime"] = DateHelper::timeDifference($lamaran_details["created_at"]); 
            unset($lowongan_details["created_at"]);
        }

        $details = array_merge(
            $lowongan_details,
            [
                'attachments' => $attachments["0"]??null,
                'company_lokasi' => $company["lokasi"],
                'company_about' => $company["about"],
                "company_name"=>$company_name["nama"],
                'lamaran_details' => $lamaran_details
            ]
        );

        return $details;
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
