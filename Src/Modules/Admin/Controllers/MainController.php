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
use Src\Modules\Admin\Models\AdminModel;

class MainController extends Controller
{

    public function indexAction($request)
    {
        return $this->renderTwig(
            '/Src/Views/layout.html.twig'
        );
    }

    public function modulesAction($request)
    {
        $modulesListForm = new ModulesListForm();

        $formRequest = $request->request->get('form');
        if (!empty($formRequest) && $formRequest == 'modules_list') {
            if (Form::isValid('modules_list')) {
                $modulesListForm->submit($request);
            }
        }

        $modulesListForm = $modulesListForm->build(array(
            'action' => '',
        ));

        Container::get('params')->setThemeData(
            array(
                'items' => array(
                    'block3' => array(
                        'modules_list_form' => array(
                            'view' => '/Src/Views/Themes/Bootstrap/Components/std_form.html.twig',
                            'vars' => array(
                                'form' => $modulesListForm->render(true),
                            )
                        )
                    )
                )
            )
        );

        return $this->renderTwig(
            '/Src/Views/layout.html.twig'
        );
    }

    public function viewMenusAction($request)
    {
        $menuList = Container::get('Main/MenuModel')->getMenuList();
        //dump($menuList);
        $list = array();
        $titles = array(
            'Список Меню',
            'Опції',
        );
        foreach ($menuList as $row) {
            $list[$row['menu_name']] = array(
                'Редагувати' => Router::buildUrl('/admin/menus', array('op' => 'edit', 'name' => $row['menu_name'])),
                'Видалити' => Router::buildUrl('/admin/menus', array('op' => 'delete', 'name' => $row['menu_name'])),
            );
        }

        //dump($vars);

        Container::get('params')->setThemeData(
            array(
                'items' => array(
                    'block3' => array(
                        'admin_menu' => array(
                            'view' => '/Src/Views/Themes/Bootstrap/Components/list_with_options.html.twig',
                            'vars' => array(
                                'list' => $list,
                                'titles' => $titles,
                            ),
                        )
                    )
                )
            )
        );

        return $this->renderTwig(
            '/Src/Views/layout.html.twig'
        );
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
                                'list' => Container::get('params')->getMenu('admin_menu'),
                                'brand' => 'НМЗД',
                            )
                        )
                    )
                )
            )
        );
    }

}