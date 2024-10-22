<?php

namespace Model;

use Core\DbCon;
use Helper\DateHelper;
use Helper\FileManager;

class Lowongan
{
    private DbCon $db;
    public function __construct()
    {
        $this->db = DbCon::getInstance();
    }

    public function addLowongan($data)
    {
        return $this->db->insert("lowongan",$data);
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

    public function getAllOpenLowongan(){
        $query = "SELECT u.nama, l.posisi, l.jenis_pekerjaan, l.jenis_lokasi, l.created_at
                  FROM lowongan l
                  JOIN users u ON u.id = l.company_id
                  WHERE l.is_open = TRUE";

        $allLowongan = $this->db->prepareQuery($query);

        if (count($allLowongan) == 0) {
            return[];
        }

        foreach ($allLowongan as &$lowongan) {
            $lowongan["lowongan_diffTime"] = DateHelper::timeDifference($lowongan["created_at"]); 
        }

        return $allLowongan;        
    }

    public function getAllLowonganByCompany($company_id) {
        $query = "SELECT u.nama, l.posisi, l.jenis_pekerjaan, l.jenis_lokasi, l.created_at
                  FROM lowongan l
                  JOIN users u ON u.id = l.company_id
                  WHERE company_id = :company_id";

        $allCompanyLowongan = $this->db->prepareQuery($query, ["company_id" => $company_id]);
        if (count($allCompanyLowongan) == 0)  {
            return [];
        }

        foreach ($allCompanyLowongan as &$lowongan) {
            $lowongan["lowongan_diffTime"] = DateHelper::timeDifference($lowongan["created_at"]); 
        }
        
        return $allCompanyLowongan;
    }

    public function getDetailLowongan($id, $user_id)
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
            ["lowongan_id" => $id, 'user_id' => $user_id]
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

    public function addAttachment($file_path,$lowongan_id){
        $this->db->insert("attachmentlowongan",[
            "file_path" => $file_path,
            "lowongan_id" => $lowongan_id,
        ]);
    }

    public function deleteAttachments($lowongan_id){
        $file_paths = $this->db->fetchQuery("SELECT file_path FROM attachmentlowongan WHERE lowongan_id=:id",['id'=>$lowongan_id]);
        if(!$file_paths){
            return;
        }
        foreach($file_paths as $file_path){
            FileManager::deleteFile($file_path);
        }
        $this->db->delete("attachmentlowongan","lowongan_id=:id",['id'=>$lowongan_id]);
    }

    public function getDataPelamar($id){
        // Lowongan Details
        $lowongan_details = $this->db->findById("lowongan", $id);
        if(!$lowongan_details){
            return [];
        }
        // $attachments = $this->db->prepareQuery(
        //     "SELECT file_path FROM attachmentlowongan WHERE lowongan_id= :lowongan_id",
        //     ["lowongan_id" => $id]
        // );

        $lowongan_details["lowongan_diffTime"] = DateHelper::timeDifference($lowongan_details["created_at"]); 

        unset($lowongan_details["created_at"]);
        unset($lowongan_details["updated_at"]);


        // Company Details
        $company = $this->db->fetchQuery("SELECT lokasi,about FROM companydetail WHERE user_id=:company_id",
        ["company_id"=>$lowongan_details['company_id']]);

        // Data lamaran
        $lamaran_details = $this->db->prepareQuery(
            "SELECT nama, status
            FROM lamaran JOIN users ON user_id = users.id
            WHERE lowongan_id=:lowongan_id",
            ["lowongan_id" => $id]
        );

        $details = array_merge(
            $lowongan_details,
            [
                // 'attachments' => $attachments["0"]??null,
                'company_lokasi' => $company["lokasi"],
                'company_about' => $company["about"],
                'lamaran_details' => $lamaran_details
            ]
        );

        return $details;
    }
}
