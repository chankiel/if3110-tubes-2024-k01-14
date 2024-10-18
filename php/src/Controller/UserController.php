<?php
namespace Controller;
class UserController extends Controller{
    public function showProfileCompany(){
        $this->view("ProfileCompany",["user"=>"123"]);
    }
}