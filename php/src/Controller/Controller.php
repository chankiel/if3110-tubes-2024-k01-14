<?php
namespace Controller;

class Controller{
    protected $auth;
    protected $cur_user;

    public function __construct(){
        $this->auth = AuthController::getCurrentUser();
        if(isset($this->auth['user'])){
            $this->cur_user = $this->auth['user'];
        }
    }

    public function model($model){
        $modelClass = "\\Model\\{$model}";
        return new $modelClass();
    }

    public function view($view, $data = []){
        extract($data);
        extract($this->auth);

        require_once __DIR__ . '/../views/'.$view.'.php';
    }

    public function showNotFound(){
        $this->view("/general/not-found");
    }

    public function handleErrors($errors,$url=''){
        session_start();
        $response =  [
            "success" => false,
            "message" => "There are validation errors.",
            "errors" => $errors
        ];

        $_SESSION['response'] =$response;
        if($url){
            header("Location: {$url}");
            exit();
        }
        return $response;
    }

    public function authorizeRole($role){
        if($this->cur_user['role']!=$role){
            header("Location: /not-found");
            exit();
        }
    }
}