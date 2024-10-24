<?php

namespace Core;

class Router
{
    private static $routes = [];

    public static function get($uri, $callback)
    {
        self::addRoute('GET', $uri, $callback);
    }

    public static function post($uri, $callback)
    {
        self::addRoute('POST', $uri, $callback);
    }

    public static function put($uri, $callback)
    {
        self::addRoute('PUT', $uri, $callback);
    }

    public static function delete($uri, $callback)
    {
        self::addRoute('DELETE', $uri, $callback);
    }

    private static function addRoute($method, $uri, $callback)
    {
        self::$routes[] = [
            'method' => $method,
            'uri' => trim($uri, '/'),
            'callback' => $callback,
        ];
    }

    public static function initRoutes(){
        self::get("/","UserController@showHome");
        self::get("/login","UserController@showLogin");
        self::get("/register", "UserController@showRegister");

        self::post("/login","AuthController@login");
        self::post("/checkPasswordConfirmation","AuthController@login");
        self::post("/register","UserController@register");
        self::post("/logout","AuthController@logout");

        self::get("/jobs/search", "LowonganController@getOpenLowongan");

        self::get("/jobs/add","LowonganController@showTambahLowongan");
        self::get("/jobs/edit/{id}","LowonganController@showEditLowongan");
        self::get("/jobs/{id}","LowonganController@showDetailLowonganCompany");
        self::get("/applications/{id}","LamaranController@showDetailLamaran");
        self::get("/profile/company","UserController@showProfileCompany");

        self::post("/jobs","LowonganController@tambahLowongan");
        self::post("/jobs/{id}","LowonganController@editLowongan");
        self::put("/applications/{id}/approve","LamaranController@approveLamaran");
        self::put("/applications/{id}/reject","LamaranController@rejectLamaran");
        self::put("/profile/company","UserController@editCompany");
        self::post("/jobs/{id}/delete","LowonganController@deleteLowongan");

        self::get("/jobs/{id}/details","LowonganController@showDetailLowonganJobseeker");
        self::get("/jobs/{id}/apply","LamaranController@showFormLamaran");
        self::get("/applications","LamaranController@showRiwayat");
        self::get("/applications/{id}","LamaranController@getExportLamaran");

        self::post( "/jobs/{id}/apply","LamaranController@tambahLamaran");

        self::get("/not-found","Controller@showNotFound");

        self::post("/jobs/{id}/close","LowonganController@changeOpenClosed");
    }

    public static function dispatch()
    {
        // Ubah http://tes.com/user/123/?q=a -> /user/123/ -> user/123/ 
        $requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        // Ambil method request (GET/POST/...)
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        foreach (self::$routes as $route) {
            // Ubah user/{id} jadi user/([a-zA-Z0-9_]+)
            $routeUri = preg_replace('#\{[a-zA-Z0-9_]+\}#', '([0-9]+)', trim($route['uri'], '/'));

            if ($route['method'] === $requestMethod && preg_match("#^{$routeUri}$#", $requestUri, $matches)) {
                array_shift($matches);
                // Kalau bentuk callbacknya langsung fungsi
                if (is_callable($route['callback'])) {
                    return call_user_func($route['callback'], $matches);
                } 
                // Kalau bentuk callbacknya seperti LamaranController@showRiwayat
                elseif (is_string($route['callback'])) {
                    list($controller, $method) = explode('@', $route['callback']);
                    $controller = "Controller\\$controller";
                    $controller = new $controller();
                    return call_user_func([$controller, $method], $matches);
                }
            }
        }
        header("Location: /not-found");
    }
}
