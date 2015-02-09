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
        Container::get('dispatcher')->dispatch('\Src\Modules\Admin\Controllers\MainController:indexAction');
        return $this->render();
    }
    /**
     * Callback for /admin/modules uri.
     *
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function modulesAction($request)
    {
        $formConf = array('action' => '');
        $this->useForm(new ModulesListForm(), $formConf, $request, 'block3');

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

                    /*'block1' => array(
                        'main_menu' => array(
                            'view' => '/Src/Views/Themes/Bootstrap/Components/navbar_top_black.html.twig',
                            'vars' => array(
                                'list' => Container::get('Main/MenuModel')->getMenu('main_menu'),
                            )
                        )
                    ),*/

                )
            )

        );
    }

}