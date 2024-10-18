<?php
namespace Controller;
use Model\Lowongan;
class LowonganController extends Controller {
    private Lowongan $model;
    public function __construct(){
        $this->model  = new Lowongan();
    }    
    public function tambahLowongan(){
        // posisi,deskripsi,jenis_pekerjaan,jenis_lokasi,attachment(s)
        
        $dataLowongan = [
            "company_id" => $_SESSION["user_id"],
            "posisi" => $_POST["posisi"],
            "deskripsi" => $_POST["deskripsi"],
            "jenis_pekerjaan" => $_POST["jenis_pekerjaan"],
            "jenis_lokasi"=> $_POST["jenis_lokasi"],
            "attachment"=> $_POST["attachment"]
        ];
        
                
        $this->model->addLowongan($dataLowongan);
    }

    public function editLowongan($params = null){

        $company_id = $_SESSION["user_id"];
        $posisi = $_POST["posisi"];
        
        $dataLowongan = [
            "company_id" => $company_id,
            "posisi" => $posisi,
            "deskripsi" => $_POST["deskripsi"],
            "jenis_pekerjaan" => $_POST["jenis_pekerjaan"],
            "jenis_lokasi"=> $_POST["jenis_lokasi"],
            "attachment"=> $_POST["attachment"],
        ];

        $condition = "id=:id";

        $this->model->updateLowongan($dataLowongan, $condition, $params);
    }

    public function hapusLowongan($params = null){
        $condition = "id= :id";
        $this->model->deleteLowongan( $condition, $params);
    }

    public function lihatDetailLowongan($params = null){
        $this->model->getDetailLowongan($params);
    }

}