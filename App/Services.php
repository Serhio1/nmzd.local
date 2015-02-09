<?php

namespace App;

use App\Core\Container;
use App\Core\Dispatcher;
use App\Core\Router;
use App\Parameters;
use \Twig_Loader_Filesystem;
use \Twig_Environment;


class Services
{

    public static function registerServices()
    {
        /*Container::register('router',function(){
            $routes = new Routes();
            $router = new Router();
            $router->setRoutes($routes->routes);

            return $router;
        });*/
        
        Container::register('session_storage',function(){
            return new SessionStorage();
        });

        Container::register('form_mngr',function(){
            $formManager = new FormManager();
            $formManager->getForms(new Forms());
            return $formManager;
        });

        Container::register('form_generator',function(){
            require_once 'vendor/php-form-generator/fg/load.php';

        });

        Container::register('pdf',function(){
            
            include(Container::get('params')->getMPdfLocation());
            $pdf = new Pdf();
            //left, right, top, bottom
            $pdf->getMPDF(new mPDF('utf-8', 'A4', '8', '', 25, 15, 20, 20, 10, 10));

            return $pdf;
        });

        Container::register('errors',function(){
            return Errors::getInstance();
        });

        Container::register('params',function(){
            return Parameters::getInstance();
        });

        Container::register('twig',function(){
            $loader = new Twig_Loader_Filesystem(Container::get('params')
                ->getViewDir());

            if (Container::get('params')->cache) {
                return new Twig_Environment($loader, array(
                    'cache' => Container::get('params')->getCacheDir(),
                ));
            } else {
                return new Twig_Environment($loader);
            }
        });

        Container::register('twigStr',function(){
            $loader = new Twig_Loader_String();

            return new Twig_Environment($loader);
        });

        Container::register('theme_settings',function(){
            $themeData = Container::get('params')->getThemeData();
            require_once 'Src/Views/Themes/' . $themeData['theme'] . '/ThemeSettings.php';

            $themeSettings = 'Src\\Views\\Themes\\' . $themeData['theme'] . '\\ThemeSettings';
            $themeSettingsInstance = new $themeSettings();
            $themeSettings = $themeSettingsInstance->getSettings();

            return $themeSettings;
        });

        /*Container::register('Admin/AdminModel',function() {
            return new \Src\Modules\Admin\Models\AdminModel();
        });*/

        Container::register('router', function() {
            return new \App\Core\Router();
        });

        Container::register('Main/ModuleModel',function() {
            return new \Src\Modules\Main\Models\ModuleModel();
        });

        Container::register('dispatcher',function() {
            return Dispatcher::getInstance();
        });

    }
    
}

