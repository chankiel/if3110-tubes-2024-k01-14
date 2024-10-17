<?php
use Core\Router;
require_once __DIR__ . '/autoload.php';

Router::get('/',function(){
    echo "Welcome";
});

Router::get('/about/{id}',function(){
    echo "Welcome 123";
});

Router::get('/applications',"LamaranController@showRiwayat");

Router::dispatch();


