<?php
namespace Controller;

class Controller{
    public function model($model){
        $modelClass = "\\Model\\{$model}";
        return new $modelClass();
    }

    public function view($view, $data = []){
        extract($data);
        require_once __DIR__ . '/../views/'.$view.'.php';
    }
}