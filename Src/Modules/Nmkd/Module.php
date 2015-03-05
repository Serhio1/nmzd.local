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
        
        Container::register('Nmkd/TypesModel',function() {
            return new \Src\Modules\Nmkd\Models\TypesModel();
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
            'createNmkd' => array(
                'uri' => '/nmkd/create',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/NmkdController',
                            'create',
                            $request
                        );
                    }
                )
            ),
            // Discipline entity
            'viewAllDiscipline' => array(
                'uri' => '/discipline',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/DisciplineController',
                            'viewAll',
                            $request,
                            true
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
                            $request,
                            true
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
                            $request,
                            true
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
                            $request,
                            true
                        );
                    }
                )
            ),
            'disciplineMenu' => array(
                'uri' => '/discipline/menu',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/DisciplineController',
                            'menu',
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
            'viewLab' => array(
                'uri' => '/lab/view',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/LabController',
                            'view',
                            $request
                        );
                    }
                )
            ),
            'createLab' => array(
                'uri' => '/lab/create',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/LabController',
                            'create',
                            $request
                        );
                    }
                )
            ),
            'editLab' => array(
                'uri' => '/lab/edit',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/LabController',
                            'edit',
                            $request
                        );
                    }
                )
            ),
            'deleteLab' => array(
                'uri' => '/lab/delete',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/LabController',
                            'delete',
                            $request
                        );
                    }
                )
            ),
                        
            // Types entity
            'viewAllTypes' => array(
                'uri' => '/types',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/TypesController',
                            'viewAll',
                            $request,
                            true
                        );
                    }
                )
            ),
            'viewType' => array(
                'uri' => '/types/view',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/TypesController',
                            'view',
                            $request,
                            true
                        );
                    }
                )
            ),
            'createType' => array(
                'uri' => '/types/create',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/TypesController',
                            'create',
                            $request,
                            true
                        );
                    }
                )
            ),
            'editType' => array(
                'uri' => '/types/edit',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/TypesController',
                            'edit',
                            $request,
                            true
                        );
                    }
                )
            ),
            'deleteType' => array(
                'uri' => '/types/delete',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Nmkd/Controllers/TypesController',
                            'delete',
                            $request,
                            true
                        );
                    }
                )
            ),
            
        );
    }
}
