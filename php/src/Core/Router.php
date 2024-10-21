<?php

namespace Core;

class Router
{
    private static $routes = [];

    public static function get($uri, $callback, $middleware = null)
    {
        self::addRoute('GET', $uri, $callback, $middleware);
    }

    public static function post($uri, $callback, $middleware = null)
    {
        self::addRoute('POST', $uri, $callback, $middleware);
    }

    public static function put($uri, $callback, $middleware = null)
    {
        self::addRoute('PUT', $uri, $callback, $middleware);
    }

    public static function delete($uri, $callback, $middleware = null)
    {
        self::addRoute('DELETE', $uri, $callback, $middleware);
    }

    private static function addRoute($method, $uri, $callback, $middleware)
    {
        self::$routes[] = [
            'method' => $method,
            'uri' => trim($uri, '/'),
            'callback' => $callback,
            'middleware' => $middleware,
        ];
    }

    public static function initRoutes(){
        self::get("/","UserController@showHome");
        self::get("/login","UserController@showLogin");
        self::get("/register", "UserController@showRegister");

        self::post("/login","AuthController@login");
        self::post("/register","UserController@register");
        self::post("/logout","AuthController@logout");

        self::get("/jobs/add","LowonganController@showTambahLowongan");
        self::get("/jobs/edit/{id}","LowonganController@showEditLowongan");
        self::get("/jobs/{id}","LowonganController@showDetailLowonganCompany");
        self::get("/applications/{id}","LamaranController@showDetailLamaran");

        self::get("/profile/company","");

        self::post("/jobs","LowonganController@tambahLowongan");
        self::put("/jobs/{id}","LowonganController@editLowongan");
        self::put("/applications/{id}/approve","");
        self::put("/applications/{id}/reject","");
        self::put("/profile/company","");

        self::get("/jobs/{id}/details","LowonganController@showDetailJS");
        self::get("/jobs/{id}/apply","LamaranController@showFormLamaran");
        self::get("/applications","LamaranController@showRiwayat");

        self::post("/jobs/{id}/apply","LamaranController@tambahLamaran");

        self::get("/not-found","Controller@showNotFound");
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
