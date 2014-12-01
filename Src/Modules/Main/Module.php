<?php

/**
 * Defines routes for Admin module.
 */

namespace Src\Modules\Main;

use App\Core\BaseModule;
use App\Core\Container;
use App\Core\Router;
use Src\Modules\Admin\Models\AdminModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Module extends BaseModule
{

    public function install()
    {

    }

    public function init()
    {
        Container::register('Main/MenuModel',function() {
            return new \Src\Modules\Main\Models\MenuModel();
        });
        Container::register('Main/MenuItemModel',function() {
            return new \Src\Modules\Main\Models\MenuItemModel();
        });

        /*Container::get('params')->setMenus('main_menu', array(
            'home' => array(
                'title' => 'Головна',
                'uri' => Router::buildUrl('/'),
                'weight' => 0,
            ),
        ));*/

        /*Container::get('params')->registerMenu('nmkd_menu', array(
            'nmkd' => array(
                'title' => 'Головна',
                'uri' => Router::buildUrl('/'),
                'weight' => 0,
            ),
        ));*/
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
            )
        );
    }
}
