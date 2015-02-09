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
    /*
     * Fires on module enabling.
     */
    public function install()
    {

    }
    /**
     * Defines module services in service container. Fires on every request.
     */
    public function init()
    {

    }

    /**
     * Main method. Fires on every request.
     *
     * @throws \Exception
     */
    public function boot()
    {

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

            // Module entity
            'viewAllModules' => array(
                'uri' => '/module',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/ModuleController',
                            'viewAll',
                            $request
                        );
                    }
                )
            ),
            'createModule' => array(
                'uri' => '/module/create',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/ModuleController',
                            'create',
                            $request
                        );
                    }
                )
            ),
            'viewModule' => array(
                'uri' => '/module/view',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/ModuleController',
                            'viewAll',
                            $request
                        );
                    }
                )
            ),
            'editModule' => array(
                'uri' => '/module/edit',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/ModuleController',
                            'edit',
                            $request
                        );
                    }
                )
            ),
            'deleteModule' => array(
                'uri' => '/module/delete',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/ModuleController',
                            'delete',
                            $request
                        );
                    }
                )
            ),

            // Menu entity
            'viewAllMenus' => array(
                'uri' => '/menu',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/MenuController',
                            'viewAll',
                            $request
                        );
                    }
                )
            ),
            'createMenu' => array(
                'uri' => '/menu/create',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/MenuController',
                            'create',
                            $request
                        );
                    }
                )
            ),
            'viewMenu' => array(
                'uri' => '/menu/view',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            //'Src/Modules/Admin/Controllers/MenuController',
                            'Src/Modules/Admin/Controllers/MenuItemController',
                            'viewAll',
                            $request
                        );
                    }
                )
            ),
            'editMenu' => array(
                'uri' => '/menu/edit',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/MenuController',
                            'edit',
                            $request
                        );
                    }
                )
            ),
            'deleteMenu' => array(
                'uri' => '/menu/delete',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/MenuController',
                            'delete',
                            $request
                        );
                    }
                )
            ),

            // MenuItem Entity
            'viewAllMenuItems' => array(
                'uri' => '/menu',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/MenuController',
                            'viewAll',
                            $request
                        );
                    }
                )
            ),
            'createMenuItem' => array(
                'uri' => '/menu/item/create',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/MenuItemController',
                            'create',
                            $request
                        );
                    }
                )
            ),

            'viewMenuItem' => array(
                'uri' => '/menu/item/view',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/MenuItemController',
                            'view',
                            $request
                        );
                    }
                )
            ),

            'editMenuItem' => array(
                'uri' => '/menu/item/edit',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/MenuItemController',
                            'edit',
                            $request
                        );
                    }
                )
            ),

            'deleteMenuItem' => array(
                'uri' => '/menu/item/delete',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Admin/Controllers/MenuItemController',
                            'delete',
                            $request
                        );
                    }
                )
            ),

        );
    }
}
