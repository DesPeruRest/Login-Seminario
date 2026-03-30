<?php

class Router
{
    public function run()
    {
        // URL por defecto
        $url = isset($_GET['url']) ? $_GET['url'] : 'auth/login';
        $url = explode('/', trim($url, '/'));

        // Controlador y método
        $controllerName = ucfirst($url[0]) . "Controller";
        $method = isset($url[1]) ? $url[1] : 'login';

        // Ruta del controlador
        $controllerPath = "../app/controllers/" . $controllerName . ".php";

        // Verificar que el controlador existe
        if (!file_exists($controllerPath)) {
            die("El controlador <b>$controllerName</b> no existe.");
        }

        require_once $controllerPath;

        $controller = new $controllerName();

        // Verificar que el método existe
        if (!method_exists($controller, $method)) {
            die("El método <b>$method</b> no existe en el controlador <b>$controllerName</b>.");
        }

        // Ejecutar método
        $controller->$method();
    }
}