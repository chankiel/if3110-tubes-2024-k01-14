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

    private static function addRoute($method, $uri, $callback, $middleware)
    {
        self::$routes[] = [
            'method' => $method,
            'uri' => trim($uri, '/'),
            'callback' => $callback,
            'middleware' => $middleware,
        ];
    }

    public static function dispatch()
    {
        // Ubah http://tes.com/user/123/?q=a -> /user/123/ -> user/123/ 
        $requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // Ambil method request (GET/POST/...)
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        foreach (self::$routes as $route) {
            // Ubah user/{id} jadi user/([a-zA-Z0-9_]+)
            $routeUri = preg_replace('#\{[a-zA-Z0-9_]+\}#', '([a-zA-Z0-9_]+)', trim($route['uri'], '/'));

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
    }
}
