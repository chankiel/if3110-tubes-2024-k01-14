<?php
namespace Controller;

class Controller{
    public function model($model){
        $modelClass = "\\Model\\{$model}";
        return new $modelClass();
    }

    public function view($view, $data = []){
        extract($data);

        $user = AuthController::getCurrentUser();
        extract($user);

        require_once __DIR__ . '/../views/'.$view.'.php';
    }

    public function showNotFound(){
        $this->view("/general/not-found");
    }
}