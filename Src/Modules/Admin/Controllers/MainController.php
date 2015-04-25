<?php

/**
 * Main controller for Admin module
 */

namespace Src\Modules\Admin\Controllers;

use App\Core\Container;
use App\Core\Controller;
use App\Core\Router;
use \PFBC\Form;
use \PFBC\View;
use Src\Modules\Admin\Forms\ModulesListForm;


class MainController extends Controller
{

    public function indexAction($request)
    {
        return $this->render();
    }
    
    public function jMenuAction($request)
    {
        $formConf = array('action' => '');
        $jsTop = array(
            'jQuery' => '/Src/Views/Themes/Bootstrap/js/jquery-1.9.1.js',
        );
        Container::get('params')->setThemeData(array('jsTop' => $jsTop));
        $this->useForm( new \Src\Modules\Admin\Forms\JMenuForm('update'), $formConf, $request, 'block3');

        return $this->render();
    }
    
    public function cacheAction($request)
    {
        $formConf = array('action' => '');
        $this->useForm( new \Src\Modules\Admin\Forms\CacheForm('update'), $formConf, $request, 'block3');

        return $this->render();
    }

    protected function preProcessView()
    {
        Container::get('params')->setThemeData('layout', '3-9');

        Container::get('params')->setThemeData(
            array(
                'items' => array(
                    'block2' => array(
                        'admin_menu' => array(
                            'view' => '/Src/Views/Themes/Bootstrap/Components/nav_vertical_pills.html.twig',
                            'vars' => array(
                                'list' => Container::get('Main/MenuModel')->getMenu('admin_menu'),
                            )
                        )
                    ),

                )
            )

        );
    }

}