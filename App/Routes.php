<?php

namespace App;

use Src\Modules\Admin\Models\AdminModel;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use src\controllers\MainController;
use App\Core\Container;

class Routes
{
    public $routes = array(
    //regexp => controller/action 
    
    //userControler
        'user/register' => 'user/register',
        'user/login' => 'user/login',
        'user' => 'user/index',
    
    //nmkdController
        'nmkd/input' => 'nmkd/input',
        'input' => 'nmkd/index',
        'nmkd/set-hierarchy' => 'nmkd/setHierarchy',
        'nmkd/set-types' => 'nmkd/setTypes',
        'questions-themes' => 'nmkd/questionsToThemes',
        /*'set-themes' => 'nmkd/setThemes',
        'set-modules' => 'nmkd/setModules',*/
        'themes-modules' => 'nmkd/themesToModules',
        'save-session' => 'nmkd/saveSession',
        'restore-session' => 'nmkd/restoreSession',
        'nmkd/edit' => 'nmkd/editNmkd',
        'nmkd/download-pdf' => 'nmkd/downloadPdf',
        'nmkd/download-pdffromstr' => 'nmkd/downloadPdfFromStr',
        'questions-upload' => 'nmkd/uploadQuestions',
        
        
    //mainController
        '' => 'main/index',     //route with empty regexp must stand at last
    );

    public static function getModules()
    {
        return Container::get('Main/ModuleModel')->getModulesForRouting();
    }

    /**
     * Aggregates routes for all enabled modules.
     */
    public static function getAll()
    {
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
                $basePath = Container::get('params')->getBasePath();
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
