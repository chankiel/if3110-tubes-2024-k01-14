<?php

namespace Model;

use Core\DbCon;
use Helper\DateHelper;

class Lamaran
{
    private DbCon $db;
    public function __construct()
    {
        $this->db = DbCon::getInstance();
    }

    // CRUD Operation

    public function addLamaran($data)
    {
        return $this->db->insert("lamaran", $data);
    }

    public function updateLamaran($data, $condition, $params)
    {
        return $this->db->update("lamaran", $data, $condition, $params);
    }

    public function deleteLamaran($condition, $params)
    {
        return $this->db->delete("lamaran", $condition, $params);
    }

    public function getLamaranById($id, $attr = "*")
    {
        return $this->db->findById('lamaran', $id, $attr);
    }

    public function getDaftarLamaranByLowongan($lowongan_id)
    {
        $sql = "SELECT * FROM company WHERE lowongan_id = $lowongan_id";
        return $this->db->rawQuery($sql);
    }

    public function getRiwayatLamaran($user_id)
    {
        $sql = "SELECT lm.lowongan_id,lo.posisi,lo.company_name,lo.jenis_pekerjaan, lo.jenis_lokasi,lm.status,lm.created_at 
        FROM lamaran lm 
        JOIN lowongan lo ON lo.id = lm.lowongan_id 
        WHERE lm.user_id = $user_id";
        return $this->db->rawQuery($sql);
    }

    public function getLamaran($user_id, $lowongan_id)
    {
        $sql = "SELECT * FROM  lamaran WHERE user_id = :user_id AND lowongan_id = :lowongan_id";
        $params = ['user_id' => $user_id, 'lowongan_id' => $lowongan_id];
        return $this->db->fetchQuery($sql, $params);
    }

    public function getDetailAllLamaran($user_id){
        $sql = "SELECT nama, email, cv_path, video_path, status, status_reason FROM users JOIN lamaran ON user_id = users.id WHERE user_id = :user_id";
        $params = ['user_id'=>$user_id];
        return $this->db->fetchQuery($sql, $params);
    }

    public function getCompanyId($lamaran_id){
        $sql = "SELECT lo.company_id FROM  lowongan lo JOIN lamaran lm ON lm.lowongan_id = lo.id WHERE lm.id= :lamaran_id";
        $params = ['lamaran_id'=>$lamaran_id];
        return $this->db->fetchQuery($sql, $params);
    }

    public function getDetailLamaran($id)
    {
        // Lamaran Details
        $lamaran_details = $this->db->findById("lamaran", $id);
        if(!$lamaran_details){
            return [];
        }

        $lowongan_details = $this->db->findById("lowongan",$lamaran_details['lowongan_id'],"company_id");

        // User Details
        $user_details = $this->db->fetchQuery("SELECT nama, email FROM users WHERE id=:user_id",
        params: ["user_id"=>$lamaran_details['user_id']]);

        $details = array_merge(
            $user_details, $lamaran_details, $lowongan_details
        );

        return $details;
    }

    public function changeStatusLamaran($status, $status_reason,$lamaran_id){
        return $this->db->update("lamaran",['status'=>$status,'status_reason'=>$status_reason],"id=:id",['id'=>$lamaran_id]);
    }

    public function authorizeFile($file_path,$user_id){
        $sql = 'SELECT la.id FROM lamaran la JOIN lowongan lo ON la.lowongan_id = lo.id 
        WHERE (la.cv_path = :file_path OR la.video_path = :file_path) AND (la.user_id = :user_id OR  lo.company_id =:user_id)';
        $params = ['file_path'=>$file_path,'user_id'=>$user_id];
        return $this->db->fetchQuery($sql,$params);
    }

    public function getDataExportLamaran($lowongan_id) {
        $sql = "SELECT u.nama as Nama_pelamar, lo.posisi as Posisi, l.created_at as Tanggal_melamar, l.cv_path as url_cv, l.video_path as url_video, l.status as Status_lamaran
                FROM lamaran l
                JOIN users u ON l.user_id = u.id
                JOIN lowongan lo ON lo.id = l.lowongan_id
                WHERE l.lowongan_id = :lowongan_id";
        $params = ["lowongan_id"=>$lowongan_id];

        $dataLamaran = $this->db->prepareQuery($sql, $params);

        return $dataLamaran;
    }

    public function getRecentApplicant($company_id) {
        $sql = "SELECT l.id as idLamaran, u.nama as nama, lo.posisi as posisi, l.created_at
                FROM lamaran l
                JOIN users u ON l.user_id = u.id
                JOIN lowongan lo ON lo.id = l.lowongan_id
                WHERE lo.company_id = :company_id
                ORDER BY l.created_at DESC
                LIMIT 5";

        $params = ["company_id" => $company_id];

        $dataRecentApplicants = $this->db->prepareQuery($sql, $params);

        foreach ($dataRecentApplicants as &$dataRecentApplicant) {
            $dataRecentApplicant["lowongan_diffTime"] = DateHelper::timeDifference($dataRecentApplicant["created_at"]); 
        }

        return $dataRecentApplicants;
    }
}
