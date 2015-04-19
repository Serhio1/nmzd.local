<?php

/**
 * Defines routes for Nmkd module.
 */

namespace Src\Modules\Pdf;

use App\Core\BaseModule;
use App\Core\Container;
use Symfony\Component\HttpFoundation\Request;

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
        Container::register('Pdf/PdfModel',function() {
            return new \Src\Modules\Pdf\Models\PdfModel();
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
            'pdfCreate' => array(
                'uri' => '/create',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/PdfController',
                            'create',
                            $request
                        );
                    }
                )
            ),
            // config entity
            'viewAllConfigs' => array(
                'uri' => '/config',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/PdfController',
                            'viewAll',
                            $request
                        );
                    }
                )
            ),
            'viewConfig' => array(
                'uri' => '/config/view',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/PdfController',
                            'view',
                            $request,
                            true
                        );
                    }
                )
            ),
            'createConfig' => array(
                'uri' => '/config/create',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/PdfController',
                            'create',
                            $request,
                            true
                        );
                    }
                )
            ),
            'editConfig' => array(
                'uri' => '/config/edit',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/PdfController',
                            'edit',
                            $request,
                            true
                        );
                    }
                )
            ),
            'deleteConfig' => array(
                'uri' => '/config/delete',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/PdfController',
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
