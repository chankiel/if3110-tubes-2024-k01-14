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
        $this->deleteAttachments($params['id']);
        return $this->db->delete("lowongan", $condition, $params);
    }

    public function getLowonganById($id)
    {
        return $this->db->findById('lowongan', $id);
    }

    public function existsLowongan($id){
        return $this->db->fetchQuery("SELECT id FROM lowongan WHERE id=:id",["id"=>$id]);
    }

    public function getAllOpenLowongan($search, $location, $job_type, $sort) 
    {
        $location = (array) $location;
        $job_type = (array) $job_type;
    
        if (count($location) > 0) {
            $location = array_map('trim', explode(',', $location[0]));
            $location = array_filter($location, function($value) {
                return !empty($value);
            });
        } else {
            $location = [];
        }
    
        if (count($job_type) > 0) {
            $job_type = array_map('trim', explode(',', $job_type[0]));
            $job_type = array_filter($job_type, function($value) {
                return !empty($value);
            });
        } else {
            $job_type = [];
        }

        $query = "";
        $params = [];

        if(isset($_SESSION["role"]) && $_SESSION["role"] === "company") {
            $query = "SELECT u.id as userid, l.id as lowonganid, l.company_name, u.nama, l.posisi, l.jenis_pekerjaan, l.jenis_lokasi, l.created_at
                            FROM lowongan l
                            JOIN users u ON u.id = l.company_id
                            WHERE (u.id = :user_id)";

            $params['user_id'] = $_SESSION["user_id"];
        } else {
            $query = "SELECT u.nama, l.id as lowonganid, l.company_name, l.posisi, l.jenis_pekerjaan, l.jenis_lokasi, l.created_at
                            FROM lowongan l
                            JOIN users u ON u.id = l.company_id
                            WHERE l.is_open = TRUE";
        }

        if(strlen($search) > 0) {
            $query .= " AND (l.posisi ILIKE :search OR u.nama ILIKE :search)";
            $params['search'] = '%' . $search . '%';
        }
    
        $query .= ($sort === "terlama") ? " ORDER BY l.created_at ASC" : " ORDER BY l.created_at DESC";
    
        $allLowongan = $this->db->prepareQuery($query, $params);
    
        foreach ($allLowongan as &$lowongan) {
            $lowongan["lowongan_diffTime"] = DateHelper::timeDifference($lowongan["created_at"]); 
        }
    
        if (count($location) === 0 && count($job_type) === 0) {
            return $allLowongan;
        } else {
            $allLowongan = array_filter($allLowongan, function($job) use ($location, $job_type) {
                $locationMatch = empty($location) || in_array($job["jenis_lokasi"], $location);
                $jobTypeMatch = empty($job_type) || in_array($job["jenis_pekerjaan"], $job_type);
                return $locationMatch && $jobTypeMatch;
            });
    
            return $allLowongan;
        }
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

        $lamaran_details = null;

        // Data lamaran
        if($user_id!=-1){
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
        }

        $details = array_merge(
            $lowongan_details,
            [
                'attachments' => empty($attachments) ? null : $attachments,
                'company_lokasi' => $company["lokasi"],
                'company_about' => $company["about"],
                "company_name"=>$company_name["nama"],
                'lamaran_details' => $lamaran_details
            ]
        );

        return $details;
    }

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

    public function getDataLowonganCompany($id){
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

        // Data lamaran
        $lamaran_details = $this->db->prepareQuery(
            "SELECT lamaran.id as lamaran_id, nama, status
            FROM lamaran JOIN users ON user_id = users.id
            WHERE lowongan_id=:lowongan_id
            ORDER BY lamaran.id",
            ["lowongan_id" => $id]
        );

        $details = array_merge(
            $lowongan_details,
            [
                'attachments' => empty($attachments) ? null : $attachments,
                'company_lokasi' => $company["lokasi"],
                'company_about' => $company["about"],
                'applications' => $lamaran_details
            ]
        );

        return $details;
    }

    public function getJobsRecommendation($cur_user){

        $query = 
        "SELECT lowongan.id, company_name, posisi, jenis_pekerjaan, jenis_lokasi
        FROM lowongan JOIN lamaran ON lowongan.id = lowongan_id 
        WHERE is_open = TRUE 
        AND lowongan.created_at >= NOW() - INTERVAL '7 days' 
        AND lamaran.user_id <> :user_id
        GROUP BY lowongan.id, company_name, posisi, jenis_pekerjaan, jenis_lokasi
        ORDER BY COUNT(lamaran.id) DESC, lowongan.created_at DESC 
        LIMIT 5";
        $param = ["user_id"=> $cur_user];
        return $this->db->prepareQuery($query, $param);
    }
}
