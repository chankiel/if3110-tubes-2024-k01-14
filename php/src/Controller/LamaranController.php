<?php
namespace Controller;

class LamaranController extends Controller{
    public function showRiwayat(){
        $this->view("RiwayatJobSeeker",["user"=>"123","nama"=>"budi"]);
    }
}