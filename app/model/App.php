<?php


final class App
{
    public static function start()
    {
        $pathInfo = Request::pathInfo();
        $pathInfo = trim($pathInfo, '/');
        $pathParts = explode('/', $pathInfo);

        if (!isset($pathParts[0]) || empty($pathParts[0])) {
            $controller = 'Index';
        } else {
            $controller = ucfirst(strtolower($pathParts[0]));
        }
            $controller .= 'Controller';

        if(!class_exists($controller)){
            $controller = 'IndexController';
        }

        if (!isset($pathParts[1]) || empty($pathParts[1])) {
            $action = 'index';
        } else {
            $action = strtolower($pathParts[1]);
        }

        if (class_exists($controller) && method_exists($controller, $action)) {
        $controllerInstance = new $controller();
        $controllerInstance->$action();
        } else {
        header("HTTP/1.0 404 Not Found");
        $view = new View();
        $view-> render('404');
        }
    }
}