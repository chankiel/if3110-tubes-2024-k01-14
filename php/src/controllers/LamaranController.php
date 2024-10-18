<?php

class LamaranController {
    private Lamaran $model;

    public function __construct(){
        $this->model = new Lamaran();
    }

    public function tambahLamaran(){
        $data = [
            "user_id" => $_POST["user_id"],
            "lowongan_id"=> $_POST["lowongan_id"],
            "cv_path"=> $_POST["cv_path"],
            "video_path"=> $_POST["video_path"],
            "status"=> "waiting",
            "reason"=> "",
        ];
        $this->model->addLamaran($data);
    }

    public function changeStatusLamaran(){
        $id = $_POST["id"];
        $data = [
            "status"=> $_POST["status"],
            "reason"=> $_POST["status_reason"],
        ];
        $condition = "id = :id";
        $param = ["id" => $id];
        $this->model->updateLamaran($data, $condition, $param );    
    } 

    public function riwayatLamaran($id){
        $this->model->getRiwayatLamaran($id);
    }
}
