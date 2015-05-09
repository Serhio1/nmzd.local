<?php

namespace App;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Container;

class Routes
{
    public static function getModules()
    {
        $modulesConfJson = file_get_contents(Container::get('params')->getConfigDir() . '/' . 'modules.json');
        $modulesConf = json_decode($modulesConfJson, true);
        return $modulesConf;
    }

    /**
     * Aggregates routes for all enabled modules.
     */
    public static function getAll()
    {
        $request = Request::createFromGlobals();
        
        $uri = $request->getRequestUri();
        $uriArr = explode('/', ltrim($uri, '/'));
        $routes = new RouteCollection();
        
        $modules = static::getModules();
        foreach ($modules as $name => $state) {
            if (!$state) {
                continue;
            }
            $path = '/Src/Modules/' . ucfirst($name);
            if (!file_exists(Container::get('params')->getBasePath() . $path . '/Module.php')) {
                continue;
            }
            
            $instance = static::pathToNamespace($path . '/Module');
            $module = new $instance();
            $module->init();
            $module->boot();
        }
        
        
        $modulePath = 'Src/Modules/Main/Module';
        $moduleSpace = static::pathToNamespace($modulePath);
        $module = new $moduleSpace;
        $module->init();
        $module->boot();
        $routes->add('home', new Route('', array(
            '_controller' => function (Request $request) {
                $controllerPath = 'Src/Modules/Main/Controllers/MainController';
                $space = static::pathToNamespace($controllerPath);
                $controller = new $space();
                $action = 'indexAction';
                return $controller->$action($request);
            }
        )));
        
         if (!empty($uriArr[0])) {
            $path = '/Src/Modules/' . ucfirst($uriArr[0]);
            $instance = static::pathToNamespace($path . '/Module');
            $module = new $instance();
            $moduleRoutes = $module->getRoutes();
            if (!empty($moduleRoutes)) {
                foreach ($moduleRoutes as $id => $params) {
                    $routes->add(str_replace('-', '_', ucfirst($uriArr[0])) . '_' . $id, new Route('/' . $uriArr[0] . $params['uri'], $params['settings']));
                }
            }
        }
        
        return $routes;
    }

    private static function pathToNamespace($path)
    {
        return str_replace('/', '\\', $path);
    }
    
}
