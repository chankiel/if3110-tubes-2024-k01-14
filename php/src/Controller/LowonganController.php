<?php

namespace Controller;
class LowonganController extends Controller{
    public function showDetailJS(){
        $this->view("DetailLowongan",["user"=>"123"]);
    }
}