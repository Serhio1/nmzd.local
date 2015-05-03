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
        if ($request->isXmlHttpRequest()) {
            if ($request->request->has('plxf')) {
                $plxf = new explode('->', $request->request->has('plxf'));
                $ctrl = new $plxf[0];
                return $ctrl->$plxf[1]($request);
            }
        }
        $basePath = Container::get('params')->getBasePath();
        $routes = new RouteCollection();
        $modules = static::getModules();

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

        $objModules = array();
        foreach ($modules as $name => $state) {
            if (!$state) {
                continue;
            }
            $path = '/Src/Modules/' . ucfirst($name);
            if (!file_exists($basePath . $path . '/Module.php')) {
                continue;
            }
            $instance = static::pathToNamespace($path . '/Module');
            $module = new $instance();
            $objModules[] = $module;
            $module->init();
            $moduleRoutes = $module->getRoutes();
            if (!empty($moduleRoutes)) {
                foreach ($moduleRoutes as $id => $params) {
                    $routes->add(str_replace('-', '_', $name) . '_' . $id, new Route('/' . $name . $params['uri'], $params['settings']));
                }
            }
        }

        foreach ($objModules as $object) {
            $object->boot();
        }

        return $routes;
    }

    private static function pathToNamespace($path)
    {
        return str_replace('/', '\\', $path);
    }
    
}
