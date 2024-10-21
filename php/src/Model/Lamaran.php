<?php

namespace Model;

use Core\DbCon;

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
}
