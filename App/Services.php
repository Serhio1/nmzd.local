<?php

namespace App;

use App\Core\Container;
use App\Core\Dispatcher;
use App\Core\Router;
use App\Parameters;
use \Twig_Loader_Filesystem;
use \Twig_Environment;
use App\Patches\Nmzd_Twig_Environment;
use Twig_Loader_String;

class Services
{

    public static function registerServices()
    {
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

            $cacheConfJson = file_get_contents(Container::get('params')->getConfigDir() . '/' . 'cache.json');
            $cacheConf = json_decode($cacheConfJson, true);
            if ($cacheConf['enable_cache']) {
                return new Nmzd_Twig_Environment($loader, array(
                    'cache' => Container::get('params')->getCacheDir(),
                ));
            } else {
                return new Nmzd_Twig_Environment($loader);
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

        Container::register('router', function() {
            return new \App\Core\Router();
        });

    }
    
}

