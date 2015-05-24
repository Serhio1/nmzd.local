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
        Container::register('Pdf/PdfConfigModel',function() {
            return new \Src\Modules\Pdf\Models\PdfConfigModel();
        });
        Container::register('Pdf/PdfTemplateModel',function() {
            return new \Src\Modules\Pdf\Models\PdfTemplateModel();
        });
        Container::register('Pdf/PdfEntityModel',function() {
            return new \Src\Modules\Pdf\Models\PdfEntityModel();
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
            'pdfTest' => array(
                'uri' => '/test',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/ConfigController',
                            'test',
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
                            'Src/Modules/Pdf/Controllers/ConfigController',
                            'viewAll',
                            $request,
                            true
                        );
                    }
                )
            ),
            'viewConfig' => array(
                'uri' => '/config/view',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/ConfigController',
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
                            'Src/Modules/Pdf/Controllers/ConfigController',
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
                            'Src/Modules/Pdf/Controllers/ConfigController',
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
                            'Src/Modules/Pdf/Controllers/ConfigController',
                            'delete',
                            $request,
                            true
                        );
                    }
                )
            ),
                        
            // pdf template entity
            'viewAllTemplates' => array(
                'uri' => '/template',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/TemplateController',
                            'viewAll',
                            $request,
                            true
                        );
                    }
                )
            ),
            'viewTemplate' => array(
                'uri' => '/template/view',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/TemplateController',
                            'view',
                            $request,
                            true
                        );
                    }
                )
            ),
            'createTemplate' => array(
                'uri' => '/template/create',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/TemplateController',
                            'create',
                            $request,
                            true
                        );
                    }
                )
            ),
            'editTemplate' => array(
                'uri' => '/template/edit',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/TemplateController',
                            'edit',
                            $request,
                            true
                        );
                    }
                )
            ),
            'deletePdfTemplate' => array(
                'uri' => '/template/delete',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/TemplateController',
                            'delete',
                            $request,
                            true
                        );
                    }
                )
            ),
                        
            // pdf entity
            'viewAllPdfEntities' => array(
                'uri' => '',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/PdfEntityController',
                            'viewAll',
                            $request,
                            true
                        );
                    }
                )
            ),
            'viewPdfEntity' => array(
                'uri' => '/view',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/PdfEntityController',
                            'view',
                            $request,
                            true
                        );
                    }
                )
            ),
            'createPdfEntity' => array(
                'uri' => '/create',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/PdfEntityController',
                            'create',
                            $request,
                            true
                        );
                    }
                )
            ),
            'editPdfEntity' => array(
                'uri' => '/edit',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/PdfEntityController',
                            'edit',
                            $request,
                            true
                        );
                    }
                )
            ),
            'deletePdfEntity' => array(
                'uri' => '/delete',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/PdfEntityController',
                            'delete',
                            $request,
                            true
                        );
                    }
                )
            ),
                        
            'downloadPdfEntity' => array(
                'uri' => '/download',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/PdfEntityController',
                            'downloadPdf',
                            $request
                        );
                    }
                )
            ),
                        
            'pdfEditor' => array(
                'uri' => '/editor',
                'settings' => array(
                    '_controller' => function (Request $request) {
                        return $this->setAction(
                            'Src/Modules/Pdf/Controllers/PdfEditorController',
                            'pdfEditor',
                            $request
                        );
                    }
                )
            ),
            
        );
    }
}
