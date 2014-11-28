<?php

/**
 * Defines routes for Devel module.
 */

namespace Src\Modules\Devel;

use App\Core\BaseModule;
use App\Core\Container;
use App\Core\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Module extends BaseModule
{
    public function install()
    {

    }

    public function init()
    {

    }

    public function boot()
    {
        Container::get('params')->registerMenu('main_menu',
            Container::get('Main/MenuModel')->getMenu('testMenu')
        );
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
            'module_generate' => array(
                'uri' => '/gen-module',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Devel/Controllers/MainController',
                            'genModule',
                            $request
                        );
                    }
                )
            ),
        );
    }
}
