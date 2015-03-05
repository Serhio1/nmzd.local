<?php

namespace App\Core;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouteCollection;
use App\Routes;
use Symfony\Component\EventDispatcher\Event;

abstract class BaseModule implements IModule
{

    protected function setAction($controllerPath, $method, $params, $secure = false)
    {
        $basePath = Container::get('params')->getBasePath();
        require_once $basePath . '/' . $controllerPath . '.php';
        $space = $this->pathToNamespace($controllerPath);
        $controller = new $space();
        $action = $method . 'Action';
        
        if ($secure) {
            if (empty($_SESSION['security_access']) || $_SESSION['security_access'] == false)
            {
                require_once $basePath . '/Src/Modules/Main/Controllers/MainController.php';
                $space = $this->pathToNamespace('Src/Modules/Main/Controllers/MainController');
                $controller = new $space();
                $action = 'securityAction';
            }
        }

        return $controller->$action($params);
    }

    protected function pathToNamespace($path)
    {
        return '\\' . str_replace('/', '\\', $path);
    }

    public function install(){}

    public function init(){}

    public function boot(){}

    public function getRoutes(){}

    public function uninstall(){}

}
