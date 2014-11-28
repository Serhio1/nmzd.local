<?php

/**
 * Defines routes for Admin module.
 */

namespace Src\Modules\Admin;

use App\Core\BaseModule;
use App\Core\Container;
use Src\Modules\Admin\Models\AdminModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Core\Router;

class Module extends BaseModule
{
    public function init()
    {

        /*Container::get('params')->registerMenu('admin_menu', array(
            'home' => array(
                'title' => 'Управління Модулями',
                'uri' => Router::buildUrl('/admin/modules'),
                'weight' => 0,
            ),
        ));*/
    }

    public function boot()
    {
        Container::get('Main/MenuModel')->setMenu(array(
            'modules' => array(
                'menu_name' => 'admin_menu',
                'parent_id' => '0',
                'title'     => 'Управління Модулями',
                'uri'       => '/admin/modules',
                'weight'    => '0',
            ),
            'menus' => array(
                'menu_name' => 'admin_menu',
                'parent_id' => '0',
                'title'     => 'Управління Меню',
                'uri'       => '/admin/menus',
                'weight'    => '1',
            ),
        ));

        Container::get('params')->registerMenu('admin_menu',
            Container::get('Main/MenuModel')->getMenu('admin_menu')
        );

        //dump(Container::get('Main/MenuModel')->getMenu('testMenu'));
    }

    /**
     * Defines array of routes for this module.
     *
     * To define route you need to add array element to result array.
     * Element must contain this structure:
     * id => array(
     *     'uri' => '/address/to/needle',
     *     'settings' => array(
     *         '_controller' => Closure
     *     ),
     * ),
     *
     * Read more in HttpKernel documentation
     * @see Symfony\Component\Routing\RouteCollection
     * @see Symfony\Component\Routing\Route
     *
     * @return array
     */
    public function getRoutes()
    {
        return array(
            'main' => array(
                'uri' => '',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/MainController',
                            'index',
                            $request
                        );
                    }
                )
            ),
            'modules' => array(
                'uri' => '/modules',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/MainController',
                            'modules',
                            $request
                        );
                    }
                )
            ),
            'menus' => array(
                'uri' => '/menus',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/MainController',
                            'viewMenus',
                            $request
                        );
                    }
                )
            ),
            'menu' => array(
                'uri' => '/menu',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/MainController',
                            'menu',
                            $request
                        );
                    }
                )
            ),

        );
    }
}
