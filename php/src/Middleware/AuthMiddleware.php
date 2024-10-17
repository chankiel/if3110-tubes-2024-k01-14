<?php
namespace Middleware;

class AuthMiddleware{
    public function handle(){
        // Ganti sama cek auth kita
        if(false){
            header("Location: /login");
            die();
        }
    }
}