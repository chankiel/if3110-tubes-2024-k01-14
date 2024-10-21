<?php
namespace Controller;
use Model\Lowongan;
use Helper\Validator;
use Helper\FileManager;

class LowonganController extends Controller {
    private Lowongan $lowongan;

    public function __construct(){
        $this->lowongan  = new Lowongan();
    }    

    public function showTambahLowongan(){
        $this->view("/company/FormTambahLowongan",[]);
    }

    public function showDetailJS($matches){
        $lowongan_id = $matches[0];
        $data = $this->lowongan->getDetailLowongan($lowongan_id);
        if(!$data){
            header("Location: /not-found");
            exit();
        }
        $this->view("/jobseeker/DetailLowongan",$data);
    }

    public function showEditLowongan($matches){
        $lowongan_id = $matches[0];

        // Cek lowongan id valid
        $lowongan = $this->lowongan->getLowonganById($lowongan_id);
        if (!$lowongan) {
            header("Location: /not-found");
        }

        $this->view("/company/editLowongan", $lowongan);
    }

    public function tambahLowongan(){
        $validator = new Validator();
        $target_url = "/";

        $company_id =  $_COOKIE["user_id"];

        $posisi = $_POST["posisi"];
        $validator->string("posisi",$posisi,"Posisi");
        if(!$validator->passes()){
            return $validator->errors();
        }

        $deskripsi = $_POST["deskripsi"];
        $validator->string("deskripsi",$deskripsi,"Deskripsi");
        if(!$validator->passes()){
            return $validator->errors();
        }

        $jenis_pekerjaan =$_POST["jenis_pekerjaan"];
        $jenis_lokasi = $_POST["jenis_lokasi"];
        // // validasi belum
        // $image_path = FileManager::uploadFile("cv");

        $dataLowongan = [
            "company_id" => $company_id,
            "posisi" => $posisi,
            "deskripsi" => $deskripsi,
            "jenis_pekerjaan" =>$jenis_pekerjaan ,
            "jenis_lokasi"=> $jenis_lokasi,
            // "file_path"=> $image_path??"",
        ];
        
                
        $this->lowongan->addLowongan($dataLowongan);
        
        header("Location: $target_url");
    }

    public function editLowongan($lowongan_id){
        $validator = new Validator();
        $target_url = "/";
        
        $company_id =  $_COOKIE["user_id"];

        $posisi = $_POST["posisi"];
        $validator->string("posisi",$posisi,"Posisi");
        if(!$validator->passes()){
            return $validator->errors();
        }

        $deskripsi = $_POST["deskripsi"];
        $validator->string("deskripsi",$deskripsi,"Deskripsi");
        if(!$validator->passes()){
            return $validator->errors();
        }

        $jenis_pekerjaan =$_POST["jenis_pekerjaan"];
        $jenis_lokasi = $_POST["jenis_lokasi"];

        // // validasi belum
        // $image_path = FileManager::uploadFile("cv");

        $dataLowongan = [
            "company_id" => $company_id,
            "posisi" => $posisi,
            "deskripsi" => $deskripsi,
            "jenis_pekerjaan" =>$jenis_pekerjaan ,
            "jenis_lokasi"=> $jenis_lokasi,
            "file_path"=> $image_path??""
        ];

        $condition = "id= :id";
        $params = ["id" => $lowongan_id];

        $this->lowongan->updateLowongan($dataLowongan, $condition, $params);

        header("Location: $target_url");
    }

    public function hapusLowongan($lowongan_id){
        $condition = "id= :id";
        $params = ["id" => $lowongan_id];
        $this->lowongan->deleteLowongan( $condition, $params);
    }

    public function getOpenLowongan(){
        $this->lowongan->getPreviewOpenLowongan();  
    }

}