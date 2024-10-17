<?php
namespace Controller;

class LamaranController extends Controller{
    public function showFormLamaran(){
        $this->view("FormLamaran");
    }

    public function showRiwayat(){
        $this->view("RiwayatJobSeeker",["user"=>"123"]);
    }
}