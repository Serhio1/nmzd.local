<?php

/**
 * Defines routes for Nmkd module.
 */

namespace Src\Modules\Nmkd;

use App\Core\BaseModule;
use App\Core\Container;
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
        Container::register('Nmkd/DisciplineModel',function() {
            return new \Src\Modules\Nmkd\Models\DisciplineModel();
        });

        Container::register('Nmkd/LabModel',function() {
            return new \Src\Modules\Nmkd\Models\LabModel();
        });
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
            // Discipline entity
            'viewAllDiscipline' => array(
                'uri' => '/discipline',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/DisciplineController',
                            'viewAll',
                            $request
                        );
                    }
                )
            ),
            'createDiscipline' => array(
                'uri' => '/discipline/create',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/DisciplineController',
                            'create',
                            $request
                        );
                    }
                )
            ),
            'viewDiscipline' => array(
                'uri' => '/discipline/view',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/DisciplineController',
                            'view',
                            $request
                        );
                    }
                )
            ),
            'editDiscipline' => array(
                'uri' => '/discipline/edit',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/DisciplineController',
                            'edit',
                            $request
                        );
                    }
                )
            ),
            'deleteDiscipline' => array(
                'uri' => '/discipline/delete',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/DisciplineController',
                            'delete',
                            $request
                        );
                    }
                )
            ),

            // Lab entity
            'viewAllLabs' => array(
                'uri' => '/lab',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/LabController',
                            'viewAll',
                            $request
                        );
                    }
                )
            ),
        );
    }
}
